<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get latest notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $user = Auth::user();
        $page_size = $request->get('page_size', 10);
        $status = $request->input('status', 'all');

        $notifications = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', $user->id)
            ->when($status != 'all', function ($query) use ($status) {
                if ($status == 'unread') {
                    $query->whereNull('read_at');
                } else {
                    $query->whereNotNull('read_at');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($page_size)
            ->through(function (Notification $notification) {
                return NotificationResource::make($notification);
            });

        return response([
            'code' => 'NOTIFICATIONS_SUCCESSFULLY_RETRIEVED',
            'data' => $notifications,
            'message' => 'Notifications successfully retrieved.'
        ],200);
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $notificationId): Response
    {
        $notification = Notification::where('id', $notificationId)->firstOrFail();

        $notification->read_at = now();
        $notification->save();

        return response([
            'code' => 'NOTIFICATIONS_SUCCESSFULLY_MARK_AS_READ',
            'notification' => NotificationResource::make($notification),
            'message' => 'Notification successfully mark as read.'
        ],200);
    }
}

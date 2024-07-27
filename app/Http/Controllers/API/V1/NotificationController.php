<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotificationController extends ApiController
{
    /**
     * Get latest notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
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

        return $this->successfulResponse(
            $notifications,
            'NOTIFICATIONS_RETRIEVED',
            'Notifications successfully retrieved.'
        );
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @param String $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $notification = Notification::where('notifiable_id', auth('api')->user()->id)
            ->where('notifiable_type', User::class)
            ->findOrFail($id);

        $notification->read_at = now();
        $notification->save();

        return $this->successfulResponse(
            true,
            'NOTIFICATIONS_MARKED_AS_READ',
            'Notification successfully mark as read.'
        );
    }
}

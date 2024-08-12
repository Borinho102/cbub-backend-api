<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\BroadcastNotification as ModelsNotification;
use App\Notifications\BroadcastNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class BroadcastNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ModelsNotification $notification;

    /**
     * Create a new job instance.
     */
    public function __construct(ModelsNotification $notification)
    {
        $this->notification = $notification;

        if ($notification->broadcast_at) {
            $this->delay = now()->addHours(Carbon::parse($notification->broadcast_at)->diffInHours(now()));
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::query()
            ->when(isset($this->notification->data['users']), function ($q) {
                $q->whereIn('id', $this->notification->data['users']);
            })
            ->whereHasRole('customer')
            ->chunk(1000, function ($users, $count) {
                Log::info('Notification chunck count => ' . $count);
                Notification::send($users, new BroadcastNotification($this->notification));
            });
    }
}

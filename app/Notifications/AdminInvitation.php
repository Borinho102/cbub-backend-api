<?php

namespace App\Notifications;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class AdminInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Invitation $invitation) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Invitation to join Cbub'))
            ->greeting(Lang::get('Hello :invitee', ['invitee' => $this->invitation->invitee->name]))
            ->line(Lang::get(':invitor invites you to join the Cbub team.', [
                'invitor' => $this->invitation->invitor->name
            ]))
            ->action(Lang::get('Join Now'), URL::temporarySignedRoute(
                'guest.admin.invitation',
                $this->invitation->expires_at,
                [
                    'token' => $this->invitation->token
                ]
            ))
            ->line(Lang::get('This invitation link will expire in :count days.', ['count' => 2]))
            ->line(Lang::get('If you do not wish to join Cbub via this invitation, no further action is required.'));
    }
}

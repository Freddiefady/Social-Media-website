<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class InvitationApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Group $group)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("User \"$notifiable->name\" has invited you to join the group \"$this->group->name\"")
            ->action('Open Group', url(route('group.show', $this->group)))
            ->line('We are happy to have you join us!');
    }
}

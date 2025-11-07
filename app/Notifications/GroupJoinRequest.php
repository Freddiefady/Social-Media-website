<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class GroupJoinRequest extends Notification
{
    public function __construct(private $group) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('User "'.$notifiable->name.'" requested to joined the group "'.$this->group->name.'"')
            ->action('Approve Group Request', route('group.show', $this->group))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

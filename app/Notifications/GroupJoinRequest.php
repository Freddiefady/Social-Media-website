<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class GroupJoinRequest extends Notification
{
    public function __construct(private readonly Group $group) {}

    /**
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("User \"$notifiable->name\" requested to joined the group \"{$this->group->name}\"")
            ->action('Approve Group Request', route('group.show', $this->group))
            ->line('Thank you for using our application!');
    }
}

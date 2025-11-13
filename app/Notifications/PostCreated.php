<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class PostCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Post $post,
        private readonly User $user,
        private readonly ?Group $group = null
    ) {}

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
            ->lineIf((bool) $this->group, "New Post was added by user {$this->user->name} in group {$this->group?->name}")
            ->lineIf(! $this->group, "New Post was added by user {$this->user->name}")
            ->action('View Post', route('post.show', $this->post->id))
            ->line('Thank you for using our application!');
    }
}

<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class ReactionOnComment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Comment $comment,
        private readonly User $user,
        private readonly Post $post
    ) {
        //
    }

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
            ->line("User {$this->user->name} has liked your comment. Your Comment: ")
            ->line("{$this->comment->comment}")
            ->action('View Post', route('post.show', $this->post->id))
            ->line('Thank you for using our application!');
    }
}

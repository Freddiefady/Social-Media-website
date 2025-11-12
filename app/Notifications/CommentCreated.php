<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

final class CommentCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Comment $comment, private readonly Post $post)
    {
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
        $comment = Str::words($this->comment->comment, 5);

        return (new MailMessage)
            ->greeting('Hello My Friend!')
            ->line("User {$this->comment->user->name} has made a comment on your post. Please see your comment below")
            ->line("$comment")
            ->action('View Post', route('post.show', $this->post->id))
            ->line('Thank you for using our application!');
    }
}

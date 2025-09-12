<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public Post $post)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Post Approved Notification')
            ->line('Your post has been approved!')
            ->action('View Post', url('/posts/' . $this->post->id))
            ->line('Thank you for using our blog!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

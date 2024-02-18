<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminMessage extends Notification
{
    use Queueable;
    private $message;
    private $title;
    private $link;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $title, $link = "")
    {
        $this->message = $message;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'title' => $this->title,
            'link' => $this->link,
            'user_id' => $notifiable->id,
            'user_name' => $notifiable->name,

        ];
    }
}

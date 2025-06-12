<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;
    protected $type;
    protected $title;
    protected $description;
    protected $image;
    protected $icon;

     
    public function __construct($type, $title, $description, $image, $icon)
    {
        $this->type = $type; // مثل: new_post, share, etc
        $this->title = $title; // "يوجد منشور جديد"
        $this->description = $description; // "في شام للتسويق الإلكتروني"
        $this->image = $image; // رابط الصورة
        $this->icon = $icon; // emoji أو رابط أيقونة
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    // ما سيتم تخزينه في جدول notifications
    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'icon' => $this->icon,
        ];
    }
}

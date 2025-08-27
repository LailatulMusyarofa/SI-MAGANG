<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiUser extends Notification
{
    use Queueable;

    // You can add properties here if needed for mail notifications.
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    // Simpan di database
    public function via($notifiable)
    {
        return ['database'];
    }

    // Data yang masuk ke tabel notifications
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}



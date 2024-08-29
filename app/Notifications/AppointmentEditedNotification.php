<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Carbon\Carbon;

class AppointmentEditedNotification extends Notification
{
    use Queueable;
   protected $originalDate;
    protected $newDate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($originalDate, $newDate)
    {
        $this->originalDate = $originalDate;
        $this->newDate = $newDate;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        $token = $notifiable->fcm_token;

        $factory = (new Factory)
            ->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();
        $formattedOriginalDate = Carbon::parse($this->originalDate)->translatedFormat('l j');
        $formattedNewDate = Carbon::parse($this->newDate)->translatedFormat('l j');

        $messageText = "Se ha movido la cita del $formattedOriginalDate al $formattedNewDate";

        $message = CloudMessage::withTarget('token', $token)->withNotification(FCMNotification::create('Cita modificada!', $messageText))->withData(['original_date' => $this->originalDate, 'new_date' => $this->newDate]);
        try {
            $messaging->send($message);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'original_date' => $this->originalDate,
            'new_date' => $this->newDate,
        ];
    }
}

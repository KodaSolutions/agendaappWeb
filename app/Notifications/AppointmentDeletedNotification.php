<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;

class AppointmentDeletedNotification extends Notification
{
    use Queueable;

    protected $appointmentDate;

    public function __construct($appointmentDate)
    {
        $this->appointmentDate = $appointmentDate;
    }
    public function via($notifiable)
    {
        return [];
    }

    public function toFcm($notifiable)
    {
        $token = $notifiable->fcm_token;
        $factory = (new Factory)
            ->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(FCMNotification::create('Appointment Eliminado', 'Se ha eliminado un appointment programado para ' . $this->appointmentDate))
            ->withData(['extra_info' => $this->appointmentDate]); 

        try {
            $messaging->send($message);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
        }
    }

    public function toArray($notifiable)
    {
        return [
            'appointment_date' => $this->appointmentDate,
        ];
    }
}



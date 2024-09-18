<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Kreait\Firebase\Messaging\ApnsConfig;
use Carbon\Carbon;

class AppointmentScheduleNotification extends Notification
{
    use Queueable;
    protected $appointmentCount;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointmentCount)
    {
        $this->appointmentCount = $appointmentCount;   
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
    public function toFcm($notifiable){
        $token = $notifiable->fcm_token;
        $factory  = (new Factory)->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();
        $messageText = "El dia de hoy tienes {$this->appointmentCount} citas. Por favor abre tu aplicación para revisarlas";
        $apnsConfig = ApnsConfig::fromArray([
            'headers' => [
                'apns-priority' => '10', 
            ],
            'payload' => [
                'aps' => [
                    'alert' => [
                        'title' => 'Recordatorio de Citas',
                        'body' => $messageText,
                    ],
                    'sound' => 'default', 
                ],
            ],
        ]);
        $message = CloudMessage::withTarget('token', $token)->withNotification(FCMNotification::create('Recordatorio de Citas', $messageText))->withData(['extra_info' => 'recordatorio_diario'])->withApnsConfig($apnsConfig);
        try {
            $messaging->send($message);
           } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('Error al enviar la notificación de recordatorio FCM: ' . $e->getMessage());
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
            'appointment_count' => $this->appointmentCount,
        ];
    }
}

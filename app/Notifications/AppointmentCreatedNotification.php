<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Carbon\Carbon;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\ApnsPayload;

class AppointmentCreatedNotification extends Notification
{
    use Queueable;
    protected $appointmentDate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($appointmentDate)
    {
        $this->appointmentDate;
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toFcm($notifiable){ 
        $token = $notifiable->fcm_token;    
        $factory = (new Factory)->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();
        $today = Carbon::now();
        $appointmentDate = Carbon::parse($this->appointmentDate);
        $diffInDays = $today->diffInDays($appointmentDate, false);
        if ($diffInDays >= 0 && $diffInDays <= 7) {
            $formattedDate = $appointmentDate->translatedFormat('l j \\d\\e F \\a \\l\\a\\s g:i A');
            $messageText = "Cita creada para el: $formattedDate";
            $apnsConfig = ApnsConfig::fromArray([
                'headers' => [
                    'apns-priority' => '10', 
                ],
                'payload' => [
                    'aps' => [
                        'alert' => [
                            'title' => 'Cita modificada!',
                            'body' => $messageText,
                        ],
                        'sound' => 'default', 
                    ],
                ],
            ]);
            $message = CloudMessage::withTarget('token', $token)->withNotification(FCMNotification::create('Cita creada', $messageText))->withData(['extra_info' => $formattedDate])->withApnsConfig($apnsConfig);
            try {
                $messaging->send($message);
            } catch (\Kreait\Firebase\Exception\MessagingException $e) {
                \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
            }
        } else {
            \Log::info('La cita no está dentro de los próximos 7 días, no se enviará la notificación.');
        }
    }
    public function toArray($notifiable)
    {
        return [
            'appointment_date' => $this->appointmentDate,
        ];
    }
}

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
use Illuminate\Support\Facades\Log;
class AlertMessageNotification extends Notification
{
    use Queueable;
    protected $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
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

    public function toFmc($notifiable)
    {
        $token = $notifiable->fcm_token;
        $factory = (new Factory)->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();
        $msg = $this->msg;
        $apnsConfig = ApnsConfig::fromArray([
            'headers' => [
                'apns-priority' => '10', 
            ],
            'payload' => [
                'aps' => [
                    'alert' => [
                        'title' => 'Importante!',
                        'body' => $msg,
                    ],
                    'sound' => 'default', 
                ],
            ],
        ]);
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(FCMNotification::create('Importante!', $msg))
            ->withData(['msg' => $this->msg])
            ->withApnsConfig($apnsConfig);
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
            'msg' => $this->msg,
        ];
    }
}

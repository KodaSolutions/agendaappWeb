<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;

class PushNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Solo devuelve el canal APN aquí
        return [ApnChannel::class];
    }

    /**
     * Send notification to APNs.
     *
     * @param  mixed  $notifiable
     * @return ApnMessage
     */
    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Titulo de Notificación')
            ->body('Este es un mensaje de prueba push')
            ->custom('user_id', $notifiable->id);
    }

    /**
     * Send notification to FCM.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function toFcm($notifiable)
    {
        // Token FCM del dispositivo
        $token = $notifiable->routeNotificationFor('fcm');

        // Crea una instancia de Firebase utilizando las credenciales de la cuenta de servicio
        $factory = (new Factory)
            ->withServiceAccount(base_path('config/serverkey.json'));

        // Crear el servicio de mensajería (FCM)
        $messaging = $factory->createMessaging();

        // Crear el mensaje de notificación
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(FCMNotification::create('Titulo de Notificación', 'Este es un mensaje de prueba push'))
            // Puedes omitir los datos adicionales si no son necesarios
            ->withData(['extra_info' => 'Hay chance que chambees?']);

        try {
            $messaging->send($message);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            // Manejar el error aquí si es necesario
            \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
        }
    }
}

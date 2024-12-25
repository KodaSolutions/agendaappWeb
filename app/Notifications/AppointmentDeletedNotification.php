<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FCMNotification;
use Carbon\Carbon;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\ApnsPayload;
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
    $factory = (new Factory)->withServiceAccount(base_path('config/serverkey.json'));
    $messaging = $factory->createMessaging();

    $today = Carbon::now();
    $appointmentDate = Carbon::parse($this->appointmentDate);
    $diffInDays = $today->diffInDays($appointmentDate, false);

    if ($diffInDays >= 0 && $diffInDays <= 7) {
        $formattedDate = $appointmentDate->translatedFormat('l j \\d\\e F \\a \\l\\a\\s g:i A');
        $messageText = "Cita eliminada para el: $formattedDate";

        // Configuración específica para iOS (APNs)
        $apnsConfig = ApnsConfig::fromArray([
            'headers' => [
                'apns-priority' => '10', // Alta prioridad para entrega inmediata
            ],
            'payload' => [
                'aps' => [
                    'alert' => [
                        'title' => 'Cita Eliminada',
                        'body' => $messageText,
                    ],
                    'sound' => 'default', // Sonido predeterminado
                    'content-available' => 1, // Permite ejecutar código en segundo plano
                ],
            ],
        ]);

        // Construcción del mensaje para FCM
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(
                FCMNotification::create('Cita Eliminada', $messageText)
            )
            ->withData([
                'appointment_date' => $formattedDate,
                'notification_type' => 'appointment_deleted',
            ])
            ->withApnsConfig($apnsConfig);

        // Envío de la notificación
        try {
            $messaging->send($message);
            \Log::info('Notificación FCM enviada con éxito al token: ' . $token);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
        } catch (\Exception $e) {
            \Log::error('Error inesperado al enviar la notificación FCM: ' . $e->getMessage());
        }
    } else {
        \Log::info('La cita no está dentro de los próximos 7 días, no se enviará la notificación');
    }
}


/*    public function toFcm($notifiable)
    {
        $token = $notifiable->fcm_token;
        $factory = (new Factory)->withServiceAccount(base_path('config/serverkey.json'));
        $messaging = $factory->createMessaging();

        $appointmentDate = Carbon::parse($this->appointmentDate);
        $formattedDate = $appointmentDate->translatedFormat('l j \\d\\e F \\d\\e Y \\a \\l\\a\\s g:i A');

        $messageText = "Se ha eliminado un appointment programado para el: $formattedDate";

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification(FCMNotification::create('Appointment Eliminado', $messageText))
            ->withData(['extra_info' => $formattedDate]);

        try {
            $messaging->send($message);
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error('Error al enviar la notificación FCM: ' . $e->getMessage());
        }

    }
*/
    public function toArray($notifiable)
    {
        return [
            'appointment_date' => $this->appointmentDate,
        ];
    }
}



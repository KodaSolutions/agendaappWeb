<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment; 
use App\Models\User;
use App\Notifications\AppointmentScheduleNotification;
use Carbon\Carbon;

class SendDailyNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:daily';
    protected $description = 'Enviar notificaciones diarias para las citas a los doctores';
    public function __construct(){ 
        parent::__construct();
    }
    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $today = Carbon::today();
            $appointments = Appointment::whereDate('appointment_date', $today)->get();
            $appointmentsByDoctor = $appointments->groupBy('doctor_id');
            
            foreach ($appointmentsByDoctor as $doctorId => $doctorAppointments) {
                $doctor = User::find(52);
                if ($doctor && $doctor->fcm_token) {
                    $appointmentCount = $doctorAppointments->count();
                    $notification = new AppointmentScheduleNotification($appointmentCount);
                    $notification->toFcm($doctor);
                }
            }

            $this->info('Recordatorios diarios enviados correctamente');
        } catch (\Exception $e) {
            \Log::error('Error en el comando notifications:daily: ' . $e->getMessage());
            $this->error('Hubo un error al enviar los recordatorios diarios');
        }
    }

    }
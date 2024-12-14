<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment2;
use App\Models\User;
use App\Models\Client;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AppointmentDeletedNotification;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentEditedNotification;
class Appointment2Controller extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'form_template_id' => 'required|exists:form_templates,id',
            'form_data' => 'required|array',
            'appointment_date' => 'required|date',
            'status' => 'sometimes|string'
        ]);
        
        return Appointment2::create($validated);
    }

    public function index(){
        return Appointment2::with('formTemplate')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);
    }

    public function show(Appointment2 $appointment)
    {
        return $appointment->load('formTemplate');
    }
}

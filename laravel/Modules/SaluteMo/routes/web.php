<?php

use Illuminate\Support\Facades\Route;
use Modules\SaluteMo\app\Http\Controllers\AppointmentController;

Route::post('/appointments/{id}/prova', [AppointmentController::class, 'prova'])->name('appointments.prova');

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\SaluteOra\Http\Controllers\CalendarController;
use Modules\SaluteOra\Http\Livewire\Calendar as CalendarComponent;

/*
|--------------------------------------------------------------------------
| Calendar Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within the SaluteOra
| module. They provide the calendar functionality for the application.
|
*/
/*
// Calendar API Routes
Route::middleware(['web', 'auth'])->prefix('api/calendar')->group(function () {
    Route::get('/config', [CalendarController::class, 'config'])->name('saluteora.calendar.config');
    Route::get('/events', [CalendarController::class, 'events'])->name('saluteora.calendar.events');
    Route::get('/available-slots', [CalendarController::class, 'availableSlots'])->name('saluteora.calendar.available-slots');
});

// Calendar Web Routes
Route::middleware(['web', 'auth'])->group(function () {
    // Main calendar view
    Route::get('/calendar', function () {
        return view('saluteora::calendar');
    })->name('saluteora.calendar');
    
    // Inline calendar component
    Route::get('/calendar/component', function () {
        return view('saluteora::components.calendar');
    })->name('saluteora.calendar.component');
});
*/

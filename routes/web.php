<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Attendance\Clock;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/attendance/clock', \App\Livewire\Attendance\Clock::class)->name('attendance.clock');
    Route::get('/attendance/history', \App\Livewire\Attendance\History::class)->name('attendance.history'); // NEW
});



require __DIR__.'/auth.php';

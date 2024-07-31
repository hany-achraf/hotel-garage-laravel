<?php

use App\Http\Controllers\PaypalController;

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('my-visit', App\Livewire\MyVisit::class)->name('my-visit');
Route::get('successful-payment', [PaypalController::class, 'success'])->name('successful-payment');
Route::get('cancelled-payment', [PaypalController::class, 'cancelled'])->name('cancelled-payment');

Route::middleware('auth')->group(function () {
    // Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    
    Route::get('dashboard', App\Livewire\Dashboard::class)->name('dashboard');

    Route::view('profile', 'profile')->name('profile');

    Route::get('security-guards', App\Livewire\SecurityGuards::class)->name('security-guards');
    
    Route::get('gates', App\Livewire\Gates::class)->name('gates');

    Route::get('visits', App\Livewire\Visits::class)->name('visits');
});

require __DIR__ . '/auth.php';

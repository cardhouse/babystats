<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('test');
})->name('home');

Route::middleware('auth')->group(function () {
    Volt::route('babies', 'babies.index')->name('babies.index');

    Volt::route('babies/create', 'babies.create')->name('babies.create');
    Volt::route('babies/{baby}', 'babies.show')->name('babies.show');
    Volt::route('babies/{baby}/edit', 'babies.edit')->name('babies.edit');

    Volt::route('diapers', 'diapers.index')->name('diapers.index');
    Volt::route('diapers/create', 'diapers.create')->name('diapers.create');
    Volt::route('diapers/{diaper}', 'diapers.show')->name('diapers.show');
    Volt::route('diapers/{diaper}/edit', 'diapers.edit')->name('diapers.edit');

    Volt::route('feedings', 'feedings.index')->name('feedings.index');
    Volt::route('feedings/create', 'feedings.create')->name('feedings.create');
    Volt::route('feedings/{feeding}', 'feedings.show')->name('feedings.show');
    Volt::route('feedings/{feeding}/edit', 'feedings.edit')->name('feedings.edit');

    Volt::route('sleeps', 'sleeps.index')->name('sleeps.index');
    Volt::route('sleeps/create', 'sleeps.create')->name('sleeps.create');
    Volt::route('sleeps/{sleep}', 'sleeps.show')->name('sleeps.show');
    Volt::route('sleeps/{sleep}/edit', 'sleeps.edit')->name('sleeps.edit');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

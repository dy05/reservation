<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/reservation', function () {
        return Inertia::render('Reservations/Show', [
            'reservations' => \App\Models\Reservation::all()
        ]);
    })->name('reservation');

    Route::get('/users', function () {
        return Inertia::render('Users/Show', [
            'users' => \App\Models\User::all()->where('id', '!=', \Illuminate\Support\Facades\Auth::user()->id)->all()
        ]);
    })->name('users.index');

//    Route::get('/users/add', function () {
//        return Inertia::render('Users/Index');
//    })->name('users.add');
//
//    Route::post('/users/add', function () {
//        return Inertia::render('Users/Add');
//    });
//
//    Route::post('/users/{user}', function () {
//        return Inertia::render('Users/Show');
//    })->name('users.show');
});

Route::group(['middleware' => config('fortify.middleware', ['web']), 'prefix' => 'reservation'], function () {
    Route::post('/', [\App\Http\Controllers\ReservationController::class, 'store'])
        ->middleware(['auth'])
        ->name('reservations.store');
    Route::get('/{reservation}', [\App\Http\Controllers\ReservationController::class, 'show'])
        ->middleware(['auth'])
        ->name('reservations.show');
    Route::put('/{reservation}', [\App\Http\Controllers\ReservationController::class, 'update'])
        ->middleware(['auth']);
    Route::delete('/{reservation}', [\App\Http\Controllers\ReservationController::class, 'delete'])
        ->middleware(['auth'])
        ->name('reservations.destroy');
});

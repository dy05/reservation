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
        return Inertia::render('Reservation/Show');
    })->name('reservation');

    Route::get('/users', function () {
        return Inertia::render('Users/Show');
    })->name('users.index');

    Route::get('/users/add', function () {
        return Inertia::render('Users/Index');
    })->name('users.add');

    Route::post('/users/add', function () {
        return Inertia::render('Users/Add');
    });

    Route::post('/users/{user}', function () {
        return Inertia::render('Users/Show');
    })->name('users.show');
});

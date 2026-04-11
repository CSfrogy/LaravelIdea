<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::get('/ideas', [IdeaController::class, 'index'])
    ->middleware('auth')
    ->name('ideas.index');
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])
    ->middleware('auth')
    ->name('idea.show');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionController::class, 'destroy'])
    ->middleware('auth');

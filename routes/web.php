<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::get('/ideas', [IdeaController::class, 'index'])->middleware('auth')
    ->name('idea.index');
Route::post('/ideas', [IdeaController::class, 'store'])->middleware('auth')
    ->name('idea.store');
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->middleware('auth')
    ->name('idea.show');

Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])
    ->name('idea.update')->middleware('auth');

Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])
    ->name('idea.destroy')->middleware('auth');

Route::delete('ideas/{idea}/image', [IdeaImageController::class, 'destroy'])
    ->name('idea.image.destroy')->middleware('auth');

Route::patch('/steps/{step}', [StepController::class, 'update'])
    ->name('step.update')->middleware('auth');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->middleware('guest')
    ->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [SessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');
Route::patch('/profile/image', [ProfileController::class, 'updateImage'])
    ->middleware('auth')
    ->name('profile.image.update');

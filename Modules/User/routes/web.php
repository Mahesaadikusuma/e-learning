<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

// Route::middleware(['auth', 'verified'])->group(function () {});
Route::get('users/search', [UserController::class, 'search'])
    ->name('users.search');
Route::resource('users', UserController::class)->names('user');

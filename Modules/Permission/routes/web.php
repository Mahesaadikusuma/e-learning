<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\PermissionController;

// Route::middleware(['auth', 'verified'])->group(function () {
// });
Route::get('permissions/search', [PermissionController::class, 'search'])
    ->name('permission.search');
Route::resource('permissions', PermissionController::class)->names('permission');

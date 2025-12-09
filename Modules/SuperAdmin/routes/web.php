<?php

use Illuminate\Support\Facades\Route;
use Modules\SuperAdmin\Http\Controllers\SuperAdminController;

// Route::middleware(['auth', 'verified'])->group(function () {
// });
Route::resource('superadmins', SuperAdminController::class)->names('superadmin');

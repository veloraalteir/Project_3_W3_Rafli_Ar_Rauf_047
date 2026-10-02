<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::patch(
    'activities/{activity}/transition',
    [ActivityController::class, 'transition']
)->name('activities.transition');

Route::resource('activities', ActivityController::class);
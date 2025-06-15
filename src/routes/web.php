<?php

use Alikhoursand\Larager\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('larager.middleware', []))
    ->get('/debug', [DebugController::class, 'index']);

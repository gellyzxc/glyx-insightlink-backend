<?php

use Illuminate\Support\Facades\Route;

Route::get('/{shortcut}', [\App\Http\Controllers\LinkController::class, 'handle']);

<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::apiResource('link', LinkController::class);


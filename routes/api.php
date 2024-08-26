<?php
use App\Http\Controllers\NotifactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ImageTextController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::resource('users', UserController::class);


Route::resource('services', ServiceController::class);

Route::post('/auth/otp', [AuthController::class, 'otp']);

Route::post('/login/phone', [AuthController::class, 'loginWithPhone']);

Route::resource('notifaction', NotifactionController::class);


Route::post('/upload', [ImageTextController::class, 'extractText']);
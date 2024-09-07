<?php
use App\Http\Controllers\Api\GroupChatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotifactionController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;




Route::post('/users/otp', [UserController::class, 'otp']);

Route::post('/users/loginphone', [UserController::class, 'loginWithPhone']);

Route::get('notifaction/{id?}', [NotifactionController::class, 'index']);
Route::delete('notifaction/{id}', [NotifactionController::class, 'destroy']);
Route::get('service', [ServiceController::class, 'index']);


Route::get('group/{id?}', [GroupChatController::class, 'index']);
Route::post('group', [GroupChatController::class, 'store']);
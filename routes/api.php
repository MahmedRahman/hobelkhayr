<?php
use App\Http\Controllers\Api\FCMNotificationController;
use App\Http\Controllers\Api\GroupChatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotifactionController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\GroupUserController;
use App\Http\Controllers\Api\FirestoreController;
use Illuminate\Support\Facades\Route;




Route::post('/users/otp', [UserController::class, 'otp']);
Route::get('/users', [UserController::class, 'index']);

Route::post('/users/loginphone', [UserController::class, 'loginWithPhone']);

Route::get('notifaction/{id?}', [NotifactionController::class, 'index']);
Route::delete('notifaction/{id}', [NotifactionController::class, 'destroy']);
Route::get('service', [ServiceController::class, 'index']);


Route::get('group/{id?}', [GroupChatController::class, 'index']);
Route::get('groupbyuser/{id}', [GroupChatController::class, 'getGroupByuser']);

Route::post('group', [GroupChatController::class, 'store']);
Route::delete('/group/{id}', [GroupChatController::class, 'deleteGroup']);

Route::get('groupUser', [GroupUserController::class, 'index']);
Route::get('groupUserbyuserid/{id}', [GroupUserController::class, 'getGroupByUserId']);

Route::post('groupUser', [GroupUserController::class, 'store']);
Route::delete('groupUser', [GroupUserController::class, 'destroy']);


Route::get('usersbygroup/{groupId}', [GroupUserController::class, 'getUsersByGroupId']);


Route::post('/add-group', [FirestoreController::class, 'addGroup']);

Route::post('/send-fcm-notification', [FCMNotificationController::class, 'sendNotification']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-info', [UserController::class, 'getUserInfoByToken']);
    Route::post('/update-user-info', [UserController::class, 'updateUserInfo']);
    Route::post('/logout', [UserController::class, 'logout']);
});
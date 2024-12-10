<?php
use App\Http\Controllers\Api\FCMNotificationController;
use App\Http\Controllers\Api\GroupChatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotifactionController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\GroupUserController;
use App\Http\Controllers\Api\FirestoreController;
use App\Http\Controllers\Admin\ForceUpdateController;
use App\Http\Controllers\Api\UserLocationController;
use App\Http\Controllers\Api\SystemSettingController; // Added this line
use Illuminate\Support\Facades\Route;

// ... (rest of the code remains the same)

// Force Update Routes
Route::post('/force-update/check', [ForceUpdateController::class, 'check']);
Route::get('/force-updates', [ForceUpdateController::class, 'index']);
Route::post('/force-updates', [ForceUpdateController::class, 'store']);
Route::put('/force-updates/{id}', [ForceUpdateController::class, 'update']);
Route::delete('/force-updates/{id}', [ForceUpdateController::class, 'destroy']);

// User Routes
Route::post('/users/otp', [UserController::class, 'otp']);
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/loginphone', [UserController::class, 'loginWithPhone']);
Route::post('/users/location', [UserLocationController::class, 'update'])
    ->middleware('auth:sanctum'); // Protect the route with authentication

// Notification Routes
Route::get('notifaction/{id?}', [NotifactionController::class, 'index']);
Route::post('notifaction/', [NotifactionController::class, 'store']);
Route::delete('notifaction/{id}', [NotifactionController::class, 'destroy']);
Route::delete('/notifications/user/{userId}', [NotifactionController::class, 'destroyAllByUserId']);
Route::post('/notifications/send-to-all', [NotifactionController::class, 'sendToAllUsers']);

// Service Routes
Route::get('service', [ServiceController::class, 'index']);

// Group Routes
Route::get('group/{id?}', [GroupChatController::class, 'index']);
Route::get('groupbyuser/{id}', [GroupChatController::class, 'getGroupByuser']);
Route::post('group', [GroupChatController::class, 'store']);
Route::delete('/group/{id}', [GroupChatController::class, 'deleteGroup']);

Route::get('groupUser', [GroupUserController::class, 'index']);
Route::get('groupUserbyuserid/{id}', [GroupUserController::class, 'getGroupByUserId']);

Route::post('groupUser', action: [GroupUserController::class, 'store']);
Route::delete('groupUser', [GroupUserController::class, 'destroy']);


Route::get('usersbygroup/{groupId}', [GroupUserController::class, 'getUsersByGroupId']);


Route::post('/add-group', [FirestoreController::class, 'addGroup']);
Route::post('/createDocument', action: [FirestoreController::class, 'createDocument']);



Route::post('/send-fcm-notification', [FCMNotificationController::class, 'sendNotification']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-info', [UserController::class, 'getUserInfoByToken']);
    Route::post('/update-user-info', [UserController::class, 'updateUserInfo']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// System Settings Routes
Route::get('/terms', [SystemSettingController::class, 'getTerms']);
Route::get('/privacy-policy', [SystemSettingController::class, 'getPrivacyPolicy']);
Route::get('/about-us', [SystemSettingController::class, 'getAboutUs']);
Route::post('/settings/update', [SystemSettingController::class, 'update']);

// ... (rest of the code remains the same)

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-info', [UserController::class, 'getUserInfoByToken']);
    Route::post('/update-user-info', [UserController::class, 'updateUserInfo']);
    Route::post('/logout', [UserController::class, 'logout']);
});
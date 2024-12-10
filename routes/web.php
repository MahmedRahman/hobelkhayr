<?php
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\NotifactionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ForceUpdateController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Admin\SystemSettingController;






Route::get('/', function () {
    return view('welcome');
});
//backend Auth




Route::get('/login', function () {
    return view('admin.pages.auth.login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login.post');




//backend Page


Route::middleware(['auth'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.pages.index');
    })->name("dashboard");

    // Force Update Management
    Route::get('/admin/force-updates', [ForceUpdateController::class, 'index'])->name('admin.force-updates.index');

    // Group Management
    Route::get('/admin/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/admin/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::put('/admin/groups/update/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/admin/groups/destroy/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');

    // Service Management
    Route::get('/admin/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/admin/services', [ServiceController::class, 'store'])->name('services.store');
    Route::post('/admin/services/update/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/admin/services/destroy/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Notification Management
    Route::get('/admin/notifications', [NotifactionController::class, 'index'])->name('admin.notifications.index');
    Route::post('/admin/notifications', [NotifactionController::class, 'store'])->name('admin.notifications.store');
    Route::delete('/admin/notifications/{id}', [NotifactionController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::post('/admin/notifications/send-to-all', [NotifactionController::class, 'sendToAllUsers'])->name('admin.notifications.sendToAll');
    Route::delete('/admin/notifications/user/{userId}', [NotifactionController::class, 'destroyAllByUserId'])->name('admin.notifications.destroyAllByUser');

    // User Management
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/user/location', [UserController::class, 'updateLocation'])->name('user.location.update');

    //logout
    Route::post('/logout', [UserController::class, 'logout'])->name("logout");

    //notifaction

    Route::get('/notification', [NotifactionController::class, 'index']);
    Route::post('/notifaction/store', [NotifactionController::class, 'store']);
    Route::delete('/notifaction/destroy/{id}', [NotifactionController::class, 'destroy']);


    //Group Type
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services/create', [ServiceController::class, 'store']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

    //Group
    Route::get('/groups', [GroupChatController::class, 'index']);
    Route::delete('/groups/destroy/{id}', [GroupChatController::class, 'destroy']);

    // System Settings Routes
    Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
        Route::get('/settings', [SystemSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [SystemSettingController::class, 'update'])->name('admin.settings.update');
    });

});




Route::get('/test-firebase', function () {
    try {
        $firebase = (new Factory)
            ->withServiceAccount(config('services.firebase.credentials_file'))
            ->createFirestore();  // You can also test other Firebase services, e.g., Realtime Database or Auth

        // Example of accessing Firestore or another Firebase service
        $database = $firebase->database();

        return response()->json([
            'success' => true,
            'message' => 'Firebase connection is successful!',
        ]);
    } catch (FirebaseException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Firebase connection failed: ' . $e->getMessage(),
        ], 500);
    }
});
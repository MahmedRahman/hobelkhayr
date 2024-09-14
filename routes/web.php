<?php
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use App\Http\Controllers\GroupChatController;
use App\Http\Controllers\NotifactionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;






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

    //user
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy']);


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
<?php
use App\Http\Controllers\FirebaseUserController;
use App\Http\Controllers\NotifactionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
//backend Auth


Route::post('/login', [AuthController::class, 'login'])->name('loginWithEmail');

Route::get('/login', function () {
    return view('admin.pages.auth.login');
});

Route::get('/sigup', function () {
    return view('admin.pages.auth.sigup');
});
//backend Page
Route::get('/admin', function () {
    return view('admin.pages.index');
})->name("dashboard");




Route::get('/user', [UserController::class, 'index']);
Route::get('/user/create', [UserController::class, 'create'])->name('users.create');

Route::get('/notifaction', [NotifactionController::class, 'index'])->name('Notifactions.index');

Route::post('/notifaction/store', [NotifactionController::class, 'store'])->name('Notifactions.store');




Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::get('/services', [ServiceController::class, 'index']);

//Route::resource('services', ServiceController::class);

Route::get('/static', function () {
    return view('admin.pages.static');
});





Route::get('/greeting', function () {
    return 'Hello World';
});
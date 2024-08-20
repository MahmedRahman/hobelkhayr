<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.pages.index');
});

Route::get('/blank', function () {
    return view('admin.pages.blank');
});
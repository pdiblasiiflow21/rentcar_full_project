<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

//Route::post('/api/login', [AuthController::class, 'login']);


Route::get('/', function () {
    return view('welcome');
});

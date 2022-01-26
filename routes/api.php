<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
  
Route::group(["middleware" => "auth.jwt"], function () {
    Route::get('topics',[TopicController::class, 'index']);   
    Route::get('topics/{id}', [TopicController::class, 'show']); 
    Route::post('topics', [TopicController::class, 'store']); 
    Route::post('topics/select', [TopicController::class, 'selectedTopic']); 
});






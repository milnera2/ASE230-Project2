<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('books', \App\Http\Controllers\Api\BookController::class);
Route::apiResource('contractors', \App\Http\Controllers\Api\ContractorController::class);
Route::apiResource('devices', \App\Http\Controllers\Api\DeviceController::class);
Route::apiResource('members', \App\Http\Controllers\Api\MemberController::class);
Route::apiResource('movies', \App\Http\Controllers\Api\MovieController::class);
Route::apiResource('orders', \App\Http\Controllers\Api\OrderController::class);
Route::apiResource('reservations', \App\Http\Controllers\Api\ReservationController::class);
Route::apiResource('scores', \App\Http\Controllers\Api\ScoreController::class);
Route::apiResource('stocks', \App\Http\Controllers\Api\StockController::class);
Route::apiResource('tasks', \App\Http\Controllers\Api\TaskController::class);
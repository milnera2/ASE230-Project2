<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::resource('books', BookController::class);

Route::resource('contractors', ContractorController::class);

Route::resource('devices', DeviceController::class);

Route::resource('members', MemberController::class);

Route::resource('movies', MovieController::class);

Route::resource('orders', OrderController::class);

Route::resource('reservations', ReservationController::class);

Route::resource('scores', ScoreController::class);

Route::resource('stocks', StockController::class);

Route::resource('tasks', TaskController::class);
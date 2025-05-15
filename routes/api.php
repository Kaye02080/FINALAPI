<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SendMoneyController;
use App\Http\Controllers\DepositMoneyController;
use App\Http\Controllers\TransactionController;
 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
   Route::get('/get-users', [UserController::class, 'getAllUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
   Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
   Route::get('/balance/{id}', [UserController::class, 'getBalance']);

   
    Route::post('/sendmoney', [SendMoneyController::class, 'send']);
   Route::post('/deposit', [DepositMoneyController::class, 'deposit']);
  Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);
    Route::put('/transaction/{id}', [TransactionController::class, 'update']);
    Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']);

    Route::post('/logout', [AuthenticationController::class, 'logout']);
});


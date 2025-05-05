<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DetailTransactionController;
use App\Http\Controllers\Api\MasterController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('master_item', MasterController::class);
Route::apiResource('table_transaction', TransactionController::class);
Route::prefix('table_transaction/{table_transaction}')->group(function () {
    Route::apiResource('detail_transaction', DetailTransactionController::class)
        ->parameters(['detail_transaction' => 'detail']); // Add this parameter mapping
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

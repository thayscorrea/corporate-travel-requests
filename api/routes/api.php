
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TravelOrderController;
use App\Http\Controllers\NotificationController;


// User authentication routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Travel order routes
    Route::get('/travel-orders', [TravelOrderController::class, 'index']);
    Route::post('/travel-orders', [TravelOrderController::class, 'store']);
    Route::get('/travel-orders/{id}', [TravelOrderController::class, 'show']);
    Route::patch('/travel-orders/{id}/status', [TravelOrderController::class, 'updateStatus']);
    Route::delete('/travel-orders/{id}', [TravelOrderController::class, 'destroy']);

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
});
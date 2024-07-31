<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\VisitController;

use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    
    Route::post('visits/{id}/end', [VisitController::class, 'end']);
    Route::post('visits', [VisitController::class, 'store']);
    Route::get('visits', [VisitController::class, 'getVisitByQrCode']);
});


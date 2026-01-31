<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProjectController;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('tickets', TicketController::class);

    Route::post('tickets/{ticket}/upload', [TicketController::class, 'upload']);
});

<?php


use App\Http\Controllers\Api\{
    AuthController,
    CompanyController,
    ProjectController,
    TicketController
};
use Illuminate\Support\Facades\Route;

// 🔓 ROTAS PÚBLICAS
Route::post('/login', [AuthController::class, 'login']);

// 🔒 ROTAS PROTEGIDAS
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);

    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);
    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets/{ticket}/upload', [TicketController::class, 'upload']);

    // temporariamente, teste no api.php
Route::get('/projects/test', function () {
    return ['ok' => true];
});

});

<?php

use App\Http\Controllers\ChatGroup\ChatGroupController;
use App\Http\Controllers\ChatGroup\ChatGroupIntegrantController;
use App\Http\Controllers\ChatGroup\ChatGroupMessageController;

Route::middleware('auth:api')->group(function() {
    Route::get('/', [ChatGroupController::class, 'index']);
    Route::post('/', [ChatGroupController::class, 'store']);
    Route::patch('/{id}', [ChatGroupController::class, 'update']);
    Route::delete('/{id}', [ChatGroupController::class, 'delete']);

    // Integrants
    Route::get('/{id}/integrants', [ChatGroupIntegrantController::class, 'index']);
    Route::post('/{id}/integrants', [ChatGroupIntegrantController::class, 'store']);
    Route::delete('/{id}/integrants', [ChatGroupIntegrantController::class, 'delete']);
    Route::patch('/{id}/integrants/{userId}', [ChatGroupIntegrantController::class, 'update']);

    // Messages
    Route::get('/{id}/messages', [ChatGroupMessageController::class, 'index']);
    Route::post('/{id}/messages', [ChatGroupMessageController::class, 'store']);
    Route::post('/{id}/messages/read', [ChatGroupMessageController::class, 'read']);
    Route::patch('/messages/{id}', [ChatGroupMessageController::class, 'update']);
    Route::delete('/messages/{id}', [ChatGroupMessageController::class, 'delete']);
});
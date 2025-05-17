<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API jalan']);
});
Route::post('/cek-status', [App\Http\Controllers\PembayaranController::class, 'checkPaymentStatus']);

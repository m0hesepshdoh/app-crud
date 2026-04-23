<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\PartController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('product', ProductController::class);

Route::apiResource('parts', PartController::class)->only(['index', 'store', 'show']);
Route::post('parts/{part}/link-vehicle', [PartController::class, 'linkVehicle']);
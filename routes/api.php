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

// Parts CRUD
Route::get('parts', [PartController::class, 'index']);
Route::post('parts', [PartController::class, 'store']);
Route::get('parts/{id}', [PartController::class, 'show']);
Route::put('parts/{id}', [PartController::class, 'update']);
Route::delete('parts/{id}', [PartController::class, 'destroy']);

// Vehicle links
Route::post('parts/{part}/link-vehicle', [PartController::class, 'linkVehicle']);
Route::put('parts/{part}/vehicle/{vehicle}', [PartController::class, 'updateVehicleLink']);
Route::delete('parts/{part}/vehicle/{vehicle}', [PartController::class, 'unlinkVehicle']);

// Vehicles CRUD
Route::get('vehicles', [PartController::class, 'getVehicles']);
Route::put('vehicles/{id}', [PartController::class, 'updateVehicle']);
Route::delete('vehicles/{id}', [PartController::class, 'destroyVehicle']);
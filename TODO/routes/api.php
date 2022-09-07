<?php

use App\Http\Controllers\WorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('works', [WorkController::class, 'index']);
Route::get('works/change-status/{id}/{status}', [WorkController::class, 'changeStatus']);
Route::post('works', [WorkController::class, 'store']);
// Route::post('works', [WorkController::class, 'store']);

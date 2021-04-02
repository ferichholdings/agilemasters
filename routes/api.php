<?php

use App\Http\Controllers\IndustryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('industry', IndustryController::class);
Route::get('/add_industry', [App\Http\Controllers\AdminController::class, 'industry_create'])->name('admin.industryCreate');

Route::resource('profile', ProfileController::class);


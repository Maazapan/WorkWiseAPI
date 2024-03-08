<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\JobsController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/offers', [OfferController::class, 'list']);
Route::get('/categories', [CategoriesController::class, 'list']);
Route::get('/companies', [CompanyController::class, 'list']);
Route::get('/jobs', [JobsController::class, 'list']);
Route::get('/users', [UsersController::class, 'list']);

Route::get('/jobs/{id}', [JobsController::class, 'item']);
Route::get('/companies/{id}', [CompanyController::class, 'item']);
Route::get('/offers/{id}', [OfferController::class, 'item']);
Route::get('/categories/{id}', [CategoriesController::class, 'item']);
Route::get('/users/{id}', [UsersController::class, 'item']);

Route::post('/companies/create', [CompanyController::class, 'create']);
Route::post('/jobs/create', [JobsController::class, 'create']);
Route::post('/categories/create', [CategoriesController::class, 'create']);
Route::post('/offers/create', [OfferController::class, 'create']);
Route::post('/users/create', [UsersController::class, 'create']);

Route::post('/offers/update', [OfferController::class, 'update']);
Route::post('/companies/update', [CompanyController::class, 'update']);
Route::post('/jobs/update', [JobsController::class, 'update']);
Route::post('/categories/update', [CategoriesController::class, 'update']);
Route::post('/users/update', [UsersController::class, 'update']);

Route::post('/auth/login', [AuthController::class, 'login']);


Route::get('/offers/user/{name}', [OfferController::class, 'offersUser']);
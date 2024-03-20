<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\OfferSaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CompanieController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/offers', [OfferController::class, 'list']);
Route::get('/categories', [CategorieController::class, 'list']);
Route::get('/companies', [CompanieController::class, 'list']);
Route::get('/jobs', [JobController::class, 'list']);
Route::get('/users', [UserController::class, 'list']);
Route::get('/comments', [CommentController::class, 'list']);

Route::get('/jobs/{id}', [JobController::class, 'item']);
Route::get('/companies/{id}', [CompanieController::class, 'item']);
Route::get('/offers/{id}', [OfferController::class, 'item']);
Route::get('/categories/{id}', [CategorieController::class, 'item']);
Route::get('/users/{id}', [UserController::class, 'item']);
Route::get('/comments/{id}', [CommentController::class, 'item']);

Route::post('/companies/create', [CompanieController::class, 'create']);
Route::post('/jobs/create', [JobController::class, 'create']);
Route::post('/categories/create', [CategorieController::class, 'create']);
Route::post('/offers/create', [OfferController::class, 'create']);
Route::post('/users/create', [UserController::class, 'create']);


Route::post('/offers/update', [OfferController::class, 'update']);
Route::post('/companies/update', [CompanieController::class, 'update']);
Route::post('/jobs/update', [JobController::class, 'update']);
Route::post('/categories/update', [CategorieController::class, 'update']);
Route::post('/users/update', [UserController::class, 'update']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/offer/title/{title}', [OfferController::class, 'offersTitle']);
Route::get('/offer/recents', [OfferController::class, 'recentOffers']);
Route::get('/offer/saves', [OfferSaveController::class, 'list']);
Route::get('/offer/saves/user/recent/{userId}', [OfferSaveController::class, 'savedRecentOfferUser']);
Route::get('/offer/saves/{id}', [OfferSaveController::class, 'item']);



Route::get('/offers/user/{title}', [OfferController::class, 'offersUser']);
Route::get('/comments/offer/{id}', [CommentController::class, 'commentsOffer']);


Route::post('/offers_save/create', [OfferSaveController::class, 'create']);
Route::post('/offers_save/delete', [OfferSaveController::class, 'delete']);
Route::post('/offers_save/saved', [OfferSaveController::class, 'isOfferSaved']);
Route::get('/offers_save/user/{userId}', [OfferSaveController::class, 'savedAllOfferUser']);
Route::get('/offers_save/user/rencent/{userId}', [OfferSaveController::class, 'savedRecentOfferUser']);
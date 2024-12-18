<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ConfigController;
use App\Http\Controllers\Api\v1\DataController;
use App\Http\Controllers\Api\v1\EstateUserController;
use App\Http\Controllers\Api\v1\RealEstateController;
use App\Http\Controllers\Api\v1\SettingsController;
use Illuminate\Support\Facades\Route;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'real-estates',
    'name' => 'real-estates.',
], function () {
    Route::get('', [RealEstateController::class, 'index']);
    Route::get('featured', [RealEstateController::class, 'featuredEstates']);
    Route::get('{estate}', [RealEstateController::class, 'show']);
    Route::post('/favourite/toggle/{estate}', [EstateUserController::class, 'toggleFavourite'])
        ->middleware('auth:sanctum');
    Route::get('/user/favourites', [EstateUserController::class, 'getFavouritesEstates'])
        ->middleware('auth:sanctum');
});

Route::group([
    'prefix' => 'config',
    'middleware' => ['api', 'auth:sanctum'],
], function () {
    Route::post('set', [ConfigController::class, 'setConfig']);
    Route::post('update', [ConfigController::class, 'updateConfig']);
    Route::get('get', [ConfigController::class, 'getConfig']);
});

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });

Route::group([
    'prefix' => 'settings',
    'middleware' => ['api'],
], function () {
    Route::get('faq', [SettingsController::class, 'getFaqData']);
    Route::get('contact', [SettingsController::class, 'getContactData']);
    Route::get('about', [SettingsController::class, 'getAboutData']);
});

Route::group([
    'prefix' => 'data',
    'name' => 'data.',
    'middleware' => ['api'],
], function () {
    Route::get('cities', [DataController::class, 'getCities']);
    Route::get('{city}/districts', [DataController::class, 'getDistricts']);
});

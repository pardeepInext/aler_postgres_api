<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactUsContoller;
use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\City;
use App\Models\State;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/countries/{q}', [AddressController::class, 'countries']);
Route::get("/states", [AddressController::class, 'states']);
Route::get("/cities", [AddressController::class, 'cities']);
Route::get('/home', [AddressController::class, 'home']);

Route::post('subscribe', [ContactUsContoller::class, 'subscribe']);

Route::post('contactmessage', [ContactUsContoller::class, 'contactMessage']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::apiResources([
    '/properties' => PropertyController::class,
    '/blogs' => BlogController::class,
    '/agents' => AgentController::class,
]);

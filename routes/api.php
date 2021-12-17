<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactUsContoller;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
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
Route::delete('logout/{id}', [AuthController::class, 'logout']);

Route::get('/dashboard', [AddressController::class, 'dashboard']);
Route::get('/messages', [ContactUsContoller::class, 'messageList']);
Route::put('/sendmessage/{id}', [ContactUsContoller::class, 'sendMessage']);
Route::put('/verifypassword/{id}', [UserController::class, 'verifyPassword']);
Route::post('/profile/{id}', [UserController::class, 'updateProfile']);

Route::post('/liketoggle',[PropertyController::class,'likeToggle']);

Route::apiResources([
    '/properties' => PropertyController::class,
    '/blogs' => BlogController::class,
    '/agents' => AgentController::class,
    '/users' => UserController::class,
    '/roles' => RoleController::class
]);

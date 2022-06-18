<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\AuthController;
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

//API route for register new user person
Route::post('/auth/register', [AuthController::class, 'register']);
//API route for login user person
Route::post('/auth/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/page/create', [ApiController::class, 'pageCreate']);
    Route::post('/follow/person/{personId}', [ApiController::class, 'followPerson']);
    Route::post('/follow/page/{pageId}', [ApiController::class, 'followPage']);
    Route::post('/person/attach-post', [ApiController::class, 'personAttachPost']);
    Route::post('/page/{pageId}/attach-post', [ApiController::class, 'pageAttachPost']);
    Route::post('/person/feed', [ApiController::class, 'personFeed']);

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

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

//API route for register new person
Route::post('/auth/register', [AuthController::class, 'register']);
//API route for login person
Route::post('/auth/login', [AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // API route for Create a Page
    Route::post('/page/create', [ApiController::class, 'pageCreate']);

    // API route for follow the another person by given id
    Route::post('/follow/person/{personId}', [ApiController::class, 'followPerson']);

    // API route for Follow the page
    Route::post('/follow/page/{pageId}', [ApiController::class, 'followPage']);

    // API route for published a post
    Route::post('/person/attach-post', [ApiController::class, 'personAttachPost']);

    // API route for published a post in a page.
    Route::post('/page/{pageId}/attach-post', [ApiController::class, 'pageAttachPost']);

    // API route for person feed
    Route::post('/person/feed', [ApiController::class, 'personFeed']);

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});

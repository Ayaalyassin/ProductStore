<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\EventController;

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

Route::post("login", [AuthUserController::class, 'login']);//->middleware('VerifyCode');
Route::post("register", [AuthUserController::class, 'register']);
Route::post('logout', [AuthUserController::class, 'logout'])->middleware('jwt.verify');
Route::get('me', [AuthUserController::class, 'me'])->middleware('jwt.verify');

Route::get('/test',[EventController::class,'testingEvents']);
Route::get('/testnoti',[EventController::class,'testnoti'])->middleware('jwt.verify');

Route::get('send-verify-mail/{email}',[AuthUserController::class,'sendVerifyMail'])->middleware('jwt.verify');

Route::middleware('jwt.verify')->group( function () {
    Route::prefix('products')->group(function(){
        Route::post('/sss',[ProductController::class,'sort']);
        Route::get('/', [ProductController::class,'index']);
        Route::post('/',[ProductController::class,'store']);
        Route::get('/{product}',[ProductController::class,'show']);
        Route::post('/{product}',[ProductController::class,'update']);
        Route::delete('/{product}',[ProductController::class,'destroy']);
    });
    Route::prefix('/{product}/comments')->group(function(){
        Route::get('/', [CommentController::class,'index']);
        Route::post('/',[CommentController::class,'store']);
        Route::post('/{comment}',[CommentController::class,'update']);
        Route::delete('/{comment}',[CommentController::class,'destroy']);
    });

    Route::post('/{product}/likes/',[LikeController::class,'store']);

    Route::get('categories/',[CategoryController::class,'index']);
    Route::post('categories/',[CategoryController::class,'store']);
    Route::get('categories/{category}',[CategoryController::class,'show']);
    Route::post('categories/{category}',[CategoryController::class,'update']);
    Route::delete('categories/{category}',[CategoryController::class,'destroy']);

});


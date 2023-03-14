<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

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

Route::post('/login', [AuthenticationController::class, 'authenticate']); //logs user in
route::post('/register', [UserController::class, 'store']); //creates account


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/store.comment', [CommentController::class, 'store']); //inserts post
    Route::post('/update.password', [PasswordController::class, 'update']); //update user password
    Route::post('/update.profileIMG', [AvatarController::class, 'update']); //update userIMG
    Route::post('/store.post', [PostController::class, 'store']); //inserts post
    Route::get('/all.posts', [PostController::class, 'getAll']); // get all posts
    Route::get('/post/{idPost}', [PostController::class, 'getPostById']); // get a specific post
});

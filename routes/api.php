<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\AvatarController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CorsMiddleware;

Route::post('/login', [AuthenticationController::class, 'authenticate'])->middleware("cors"); //logs user in
route::post('/register', [UserController::class, 'store']); //creates account


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/userStoreInfo', [AuthenticationController::class, 'get']); //gets user info for Vue
    Route::post('/update.user', [UserController::class, 'update']); //updates post
    Route::post('/update.post/{idPost}', [PostController::class, 'update']); //updates post
    Route::post('/insert.comment/{idPost}', [PostController::class, 'store']); //updates post
    Route::get('/user', [UserController::class, 'get']); //gets user info
    Route::delete('/delete.post/{idPost}', [PostController::class, 'delete']); //inserts post

    Route::post('/store.comment/{idPost}', [CommentController::class, 'store']); //inserts post
    Route::post('/update.password', [PasswordController::class, 'update']); //update user password
    Route::post('/update.profileIMG', [AvatarController::class, 'update']); //update userIMG
    Route::post('/store.post', [PostController::class, 'store']); //inserts post
    Route::get('/all.posts', [PostController::class, 'getAll']); // get all posts
    Route::get('/post/{idPost}', [PostController::class, 'getPostById']); // get a specific post
    Route::get('/post.private/{idPost}', [PostController::class, 'getPostByIdPrivate']); // get a specific post

});

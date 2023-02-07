<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get(
    '/login',
    [AuthenticationController::class, 'showLogin']
)->name('showLogin');

Route::get(
    '/register',
    [AuthenticationController::class, 'showRegister']
)->name('showRegister');


Route::get(
    '/createComment',
    [CommentController::class, 'showCreateComment']
)->name('showCreateComment')->middleware('auth');

Route::get(
    '/createPost',
    [PostController::class, 'showCreatePost']
)->name('showCreatePost')->middleware('auth');

Route::get(
    '/postIndex',
    [PostController::class, 'showPostIndex']
)->name('showPostIndex')->middleware('auth');


Route::get('/', function () {
    return view('main');
})->name('showMain');

Route::post(
    '/register',
    [AuthenticationController::class, 'store']
)->name('registerUser');

Route::post(
    '/login',
    [AuthenticationController::class, 'authenticate']
)->name('authenticateUser');

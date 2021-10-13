<?php

use App\Models\Comment;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserCommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

Route::get('/secret', [App\Http\Controllers\HomeController::class, 'secret'])->name('secret')
->middleware('can:secret.page');

Route::get('/posts/archive',[PostController::class,'archive']);
Route::get('/posts/all',[PostController::class,'all']);
Route::patch('/posts/{id}/restore',[PostController::class,'restore']);
Route::delete('/posts/{id}/forcedelete',[PostController::class,'forcedelete']);

Route::get('/posts/tag/{id}',[PostTagController::class,'index'])->name('posts.tag.index');
Route::resource('posts', PostController::class)/*->Middleware('auth')*/ ;

Route::resource('users',UserController::class)->only(['show','edit','update']);
Route::resource('posts.comments', PostCommentController::class)->only('store');
Route::resource('users.comments', UserCommentController::class)->only('store');


Route::get('/mailable', function () {
    $comment = Comment::find(5);
    return new App\Mail\CommentedPostMarkdown($comment);
});

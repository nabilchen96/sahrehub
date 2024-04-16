<?php

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

//HOME
Route::get('/', 'App\Http\Controllers\PostController@index');
Route::get('/data-post', 'App\Http\Controllers\PostController@data');
Route::get('/data-popular', 'App\Http\Controllers\PostController@dataPopular');

//EKSPLOR
Route::get('/eksplor', 'App\Http\Controllers\EksplorController@index');
Route::get('/data-eksplor', 'App\Http\Controllers\EksplorController@data');

//LOGIN
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/login-proses', 'App\Http\Controllers\AuthController@loginProses');

//LOGOUT
Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');

//PROFILE
Route::get('/profil', 'App\Http\Controllers\ProfileController@index');
Route::get('/data-profil', 'App\Http\Controllers\ProfileController@dataProfile');
Route::get('/data-profil-post', 'App\Http\Controllers\ProfileController@dataProfilePost');

//DETAIL POST
Route::get('/detail-post', 'App\Http\Controllers\PostController@detail');

//KOMENTAR
Route::get('/data-comment', 'App\Http\Controllers\CommentController@data');
Route::post('/store-comment', 'App\Http\Controllers\CommentController@store');
Route::post('/delete-comment', 'App\Http\Controllers\CommentController@delete');

Route::middleware(['auth'])->group(function () {

    //POST
    Route::get('/create-post', 'App\Http\Controllers\PostController@create');
    Route::post('/store-post', 'App\Http\Controllers\PostController@store');
    Route::post('/like-post', 'App\Http\Controllers\PostController@like');
    Route::post('/bookmark-post', 'App\Http\Controllers\PostController@bookmark');
    Route::post('/up-post', 'App\Http\Controllers\PostController@up');

    Route::get('/edit-post', 'App\Http\Controllers\PostController@edit');
    Route::post('/update-post', 'App\Http\Controllers\PostController@update');
    Route::post('/delete-post', 'App\Http\Controllers\PostController@delete');

    //PROFIL
    Route::post('/update-profil', 'App\Http\Controllers\ProfileController@update');

    //AKTIVITAS
    Route::get('/like-activity', 'App\Http\Controllers\ActivityController@like');
    Route::get('/data-like-activity', 'App\Http\Controllers\ActivityController@dataLike');

    Route::get('/bookmark-activity', 'App\Http\Controllers\ActivityController@bookmark');
    Route::get('/data-bookmark-activity', 'App\Http\Controllers\ActivityController@dataBookmark');

    Route::get('/post-activity', 'App\Http\Controllers\ActivityController@post');
    Route::get('/data-post-activity', 'App\Http\Controllers\ActivityController@dataPost');

    Route::get('/comment-activity', 'App\Http\Controllers\ActivityController@comment');
    Route::get('/data-comment-activity', 'App\Http\Controllers\ActivityController@dataComment');

    Route::get('/up-activity', 'App\Http\Controllers\ActivityController@up');
    Route::get('/data-up-activity', 'App\Http\Controllers\ActivityController@dataUp');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::resource('posts', PostController::class);

//   GET|HEAD        posts                         posts.index › PostController@index
//   POST            posts ..........              posts.store › PostController@store
//   GET|HEAD        posts/create .                posts.create › PostController@create
//   GET|HEAD        posts/{post} .....            posts.show › PostController@show
//   PUT|PATCH       posts/{post} .                posts.update › PostController@update
//   DELETE          posts/{post} ......           posts.destroy › PostController@destroy
//   GET|HEAD        posts/{post}/edit             posts.edit › PostController@edit

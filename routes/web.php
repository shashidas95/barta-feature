<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class, ['parameters' => [
        'post' => 'id'
    ]]);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    // Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    // Route::delete('/posts', [PostController::class, 'destroy'])->name('posts.destroy');

});

require __DIR__ . '/auth.php';

// /*
//  GET|HEAD        posts             ............ posts.index › PostController@index
//   POST            posts             ............ posts.store › PostController@store
//   GET|HEAD        posts/create             ... posts.create › PostController@create
//   GET|HEAD        posts/{post}             ....... posts.show › PostController@show
//   PUT|PATCH       posts/{post}             ... posts.update › PostController@update
//   DELETE          posts/{post}             . posts.destroy › PostController@destroy
//   GET|HEAD        posts/{post}/edit             .. posts.edit › PostController@edit

// /*

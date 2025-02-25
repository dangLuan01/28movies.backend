<?php

use App\Http\Controllers\Movie\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;




//Auth::routes(['verify' => true]);

Route::middleware(['auth:web'])->group(function () {
    // Route::resource('movie/article', 'Flight\ArticleController', ['as' => 'flight']);
    // Route::get('flight/article/status/{status}/{id}', [ArticleController::class, 'status'])->name('flight.article.status');
    // Route::post('flight/article/confirm-delete', [ArticleController::class, 'confirmDelete'])->name('flight.article.confirm-delete');
});
Route::resource('movie/product', ProductController::class, ['as' => 'movie']);
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

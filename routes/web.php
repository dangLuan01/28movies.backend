<?php

use App\Http\Controllers\Dashboard\DashboardController;
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
Route::get('movie/product/status/{status}/{id}', [ProductController::class, 'status'])->name('movie.product.status');
// Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//Route::post('/get-movie-tmdb', [DashboardController::class, 'getMovieTmdb'])->name('get-movie-tmdb');
//Route::post('/save-auto-movie', [DashboardController::class, 'saveAutoMovie'])->name('save-auto-movie');
// TEST
Route::get('/test', [DashboardController::class, 'test'])->name('test');



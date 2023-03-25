<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::get('news/{article}', [NewsController::class, 'show'])->name('news.show');
    Route::post('news/store', [NewsController::class, 'store'])->name('news.store');
    Route::post('news/{article}/publish', [NewsController::class, 'publish'])->name('news.publish');
    Route::post('{article}/comments/store', [CommentsController::class, 'store'])->name('comments.store');
    Route::post('comments/{comment}/publish', [CommentsController::class, 'publish'])->name('comments.publish');
    Route::post('{article}/grades', [GradesController::class, 'store'])->name('grades.store');
    Route::get('profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
});

<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('the-loai/{slug}', [HomeController::class, 'show']);
Route::get('tim-kiem', [HomeController::class, 'search']);


Route::get('login', [UserController::class, 'index'])->name('login');
Route::get('register', [UserController::class, 'show'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::post('upload/services', [UploadController::class, 'store']);

Route::middleware(['auth'])->group(function() {
    Route::prefix('admin')->middleware('admin')->group(function() {
        Route::get('/', function () {
            return view('welcome');
        })->name('welcome');

        Route::prefix('genre')->group(function() {
            Route::get('add', [GenreController::class, 'create']);
            Route::post('add', [GenreController::class, 'store']);
            Route::get('list', [GenreController::class, 'index']);
            Route::get('edit/{id}', [GenreController::class, 'show']);
            Route::post('edit/{id}', [GenreController::class, 'update']);
            Route::delete('destroy', [GenreController::class, 'destroy']);
        });

        Route::prefix('story')->group(function() {
            Route::get('add', [StoryController::class, 'create']);
            Route::post('add', [StoryController::class, 'store']);
            Route::get('list', [StoryController::class, 'index']);
            Route::get('edit/{id}', [StoryController::class, 'show']);
            Route::post('edit/{id}', [StoryController::class, 'update']);
            Route::delete('destroy', [StoryController::class, 'destroy']);
        });

        Route::prefix('chapter')->group(function() {
            Route::get('add', [ChapterController::class, 'create']);
            Route::post('add', [ChapterController::class, 'store']);
            Route::get('list', [ChapterController::class, 'index']);
            Route::get('edit/{id}', [ChapterController::class, 'show']);
            Route::post('edit/{id}', [ChapterController::class, 'update']);
            Route::delete('destroy', [ChapterController::class, 'destroy']);
        });
    });
});

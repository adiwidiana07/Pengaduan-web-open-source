<?php

use App\Http\Controllers\AspirationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AspirationController as AdminAspirationController;
use App\Http\Controllers\MyAspirationController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/aspirasi', [AspirationController::class, 'index'])->name('aspirasi.index');
Route::get('/aspirasi/create', [AspirationController::class, 'create'])->name('aspirasi.create');
Route::post('/aspirasi', [AspirationController::class, 'store'])->name('aspirasi.store');
Route::get('/aspirasi/{aspiration}/success', [AspirationController::class, 'success'])->name('aspirasi.success');
Route::get('/aspirasi/{aspiration}', [AspirationController::class, 'show'])->name('aspirasi.show');
Route::post('/aspirasi/{aspiration}/vote', [VoteController::class, 'vote'])->name('aspirasi.vote');
Route::post('/aspirasi/{aspiration}/comment', [CommentController::class, 'store'])->name('aspirasi.comment');
Route::get('/aspirasi/{aspiration}/edit', [AspirationController::class, 'edit'])->name('aspirasi.edit');
Route::put('/aspirasi/{aspiration}', [AspirationController::class, 'update'])->name('aspirasi.update');
Route::delete('/aspirasi/{aspiration}', [AspirationController::class, 'destroy'])->name('aspirasi.destroy');

Route::get('/my-aspirations', [MyAspirationController::class, 'index'])->name('my.aspirations');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/aspirasi', [AdminAspirationController::class, 'index'])->name('admin.aspirasi.index');
    Route::get('/aspirasi/{aspiration}', [AdminAspirationController::class, 'show'])->name('admin.aspirasi.show');

    Route::get('/kategori', [CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [CategoryController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{category}/edit', [CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{category}', [CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/statistik', [StatisticController::class, 'index']);
    Route::get('/profil', [ProfileController::class, 'show']);
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

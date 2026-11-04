<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialAuthController;
use App\Livewire\ExploreMap;
use App\Livewire\ProfileEditor;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/adoptar', 'adopt')->name('adopt');
Route::get('/explore', ExploreMap::class)->name('explore');
Route::get('/nosotros', [HomeController::class, 'about'])->name('about');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');
});
Route::middleware('auth')->group(function () {
    Route::get('/inicio', [HomeController::class, 'dashboard'])->name('inicio');
    Route::get('/profile', ProfileEditor::class)->name('profile');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});

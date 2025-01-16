<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;


/*Route::get('/', function () {
    return view('welcome');
});*/

//1º
Auth::routes(['verify' => true]);


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
Route::post('/profile/change-email', [ProfileController::class, 'changeEmail'])->name('profile.changeEmail');
Route::post('/profile/change-username', [ProfileController::class, 'changeUsername'])->name('profile.changeUsername');

Route::middleware(['auth', ])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
});
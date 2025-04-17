<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

Route::get('/', function () {
    $users = User::limit(1)->get();
    if ($users->count() == 0) {
        return Inertia::render('Welcome'); // with register button
    } else {
        return Inertia::render('WelcomeNoRegister'); // with no register button
    }

})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\ComplaintController;
Route::middleware('auth')->group(function () {
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::get('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::get('/complaint/search', [ComplaintController::class, 'search'])->name('complaint.search');
    Route::post('/complaint/post', [ComplaintController::class, 'store'])->name('complaint.post');
    Route::get('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::post('/complaint/{complaint}/update', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::get('/complaint/{complaint}/show', [ComplaintController::class, 'show'])->name('complaint.show');
    Route::get('/complaint/{complaint}/delete', [ComplaintController::class, 'destroy'])->name('complaint.delete');
});

use App\Http\Controllers\UserController;
Route::middleware('first_admin')->group(function () {
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index1');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/{user}/show', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

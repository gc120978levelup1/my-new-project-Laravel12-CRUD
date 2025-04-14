<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


use App\Http\Controllers\ComplaintController;
Route::middleware('auth')->group(function () {
  Route::get ('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
  Route::get ('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
  Route::post('/complaint/post', [ComplaintController::class, 'store'])->name('complaint.post');
  Route::get ('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
  Route::post('/complaint/{complaint}/update', [ComplaintController::class, 'update'])->name('complaint.update');
  Route::get ('/complaint/{complaint}/show', [ComplaintController::class, 'show'])->name('complaint.show');
  Route::get ('/complaint/{complaint}/delete', [ComplaintController::class, 'destroy'])->name('complaint.delete');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

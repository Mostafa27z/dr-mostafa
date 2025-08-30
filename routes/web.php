<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/lessons', function () {
    return view('lessons');
})->name('lessons');
Route::get('/sessions', function () {
    return view('sessions');
})->name('sessions');
Route::get('/groups', function () {
    return view('groups');
})->name('groups');
Route::get('/assignments', function () {
    return view('assignments');
})->name('assignments');
Route::get('/exams', function () {
    return view('exams');
})->name('exams');
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute za pitanja
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{status}', [QuestionController::class, 'indexByStatus'])->name('questions.status');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/questions/{question}/toggle-status', [QuestionController::class, 'toggleStatus'])->name('questions.toggleStatus');


    // Test mode
    Route::get('/test/hint', [QuestionController::class, 'showHint'])->name('test.hint');
    Route::get('/test/categories', [QuestionController::class, 'showTestCategories'])->name('test.categories');
    Route::post('/test/start', [QuestionController::class, 'startTest'])->name('test.start');
    Route::post('/test/answer', [QuestionController::class, 'submitTestAnswer'])->name('test.answer');
    Route::get('/test/question', [QuestionController::class, 'showCurrentTestQuestion'])->name('test.question'); // Dodata GET ruta za prikaz pitanja sa hintom

    // Rute za profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

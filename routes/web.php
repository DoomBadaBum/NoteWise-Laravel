<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RemarkController;

Route::get('/', function () {
    return redirect()->route('notes.index');
});

// Group the notes and remarks routes under "auth" middleware
Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
    Route::post('/notes/{note}/remarks', [RemarkController::class, 'store'])
         ->name('remarks.store');
    Route::get('/my-notes', [NoteController::class, 'myNotes'])->name('notes.myNotes');
});

// Laravel authentication routes (login, register, password reset, etc.)
Auth::routes();

// Optional: if you want a separate "home" page for logged-in users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
     ->name('home');
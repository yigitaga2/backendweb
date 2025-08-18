<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserLibraryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes
Route::get('/profile/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book management
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // User library management
    Route::get('/library', [UserLibraryController::class, 'index'])->name('library.index');
    Route::post('/library', [UserLibraryController::class, 'store'])->name('library.store');
    Route::patch('/library/{book}', [UserLibraryController::class, 'update'])->name('library.update');
    Route::delete('/library/{book}', [UserLibraryController::class, 'destroy'])->name('library.destroy');

    // Review management
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin only routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');

    // Contact Management
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);
    Route::patch('/contacts/{contact}/toggle-read', [AdminContactController::class, 'toggleRead'])->name('contacts.toggle-read');

    // News management
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news:slug}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::patch('/news/{news:slug}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news:slug}', [NewsController::class, 'destroy'])->name('news.destroy');

    // FAQ management
    Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
    Route::get('/faq/{faq}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::patch('/faq/{faq}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{faq}', [FaqController::class, 'destroy'])->name('faq.destroy');
});

require __DIR__.'/auth.php';

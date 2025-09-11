<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Authentication routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot password routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.update');
});


// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Posts management routes
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// Admin only routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Category management routes
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Admin dashboard and post review routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/posts/{post}/review', [AdminController::class, 'reviewPost'])->name('admin.review-post');
    Route::patch('/admin/posts/{post}/approve', [AdminController::class, 'approvePost'])->name('admin.approve-post');
    Route::patch('/admin/posts/{post}/reject', [AdminController::class, 'rejectPost'])->name('admin.reject-post');
});

// Public routes
Route::view('/', 'welcome')->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');








// Route for testing purpose
Route::get('/test', function () {
    $title = 'Test Page';
    $content = 'This is a test page.';
    return view('test', compact('title', 'content'));
});














// Sample users data
$users = [
    [
        'id' => 1,
        'name' => 'Sia',
        'age' => 25
    ],
    [
        'id' => 2,
        'name' => 'John',
        'age' => 30
    ]
];

// For testing purpose
Route::get('/users', function () use ($users) {
    return $users;
});

Route::get('/users/{id}', function ($id) use ($users) {
    return $users[$id - 1] ?? abort(404);
});

Route::post('/users', function (Request $request) use ($users) {
    $users[] = [
        'id' => count($users) + 1,
        'name' => $request->input('name'),
        'age' => $request->input('age')
    ];
    return response($users[count($users) - 1], 201);
});

Route::put('/users/{id}', function (Request $request, $id) use ($users) {
    if (!isset($users[$id - 1])) {
        abort(404);
    }
    $users[$id - 1]['name'] = $request->input('name', $users[$id - 1]['name']);
    $users[$id - 1]['age'] = $request->input('age', $users[$id - 1]['age']);
    return $users[$id - 1];
});

Route::delete('/users/{id}', function ($id) use ($users) {
    if (!isset($users[$id - 1])) {
        abort(404);
    }
    unset($users[$id - 1]);
    return 'User deleted successfully';
});
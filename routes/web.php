<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ModerationController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (requires auth) - HARUS SEBELUM PUBLIC ROUTES YANG LEBIH UMUM
Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [UserController::class, 'myProfile'])->name('profile.my-profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
    Route::get('/portfolio/{portfolio}/settings', [PortfolioController::class, 'settings'])->name('portfolio.settings');
    Route::put('/portfolio/{portfolio}/settings', [PortfolioController::class, 'updateSettings'])->name('portfolio.updateSettings');
    Route::post('/portfolio/reorder', [PortfolioController::class, 'reorderPortfolios'])->name('portfolio.reorder');
    
    // Comments and Likes
    Route::post('/portfolio/{portfolio}/comment', [PortfolioController::class, 'addComment'])->name('comment.add');
    Route::post('/portfolio/{portfolio}/like', [PortfolioController::class, 'toggleLike'])->name('like.toggle');

    // Company Routes
    Route::get('/company/saved-creators', [CompanyController::class, 'savedCreators'])->name('company.saved-creators');
    Route::post('/company/save-creator/{creator}', [CompanyController::class, 'saveCreator'])->name('company.save-creator');
    Route::post('/company/contact-creator/{creator}', [CompanyController::class, 'contactCreator'])->name('company.contact-creator');

    // Chat Routes
    Route::get('/chat/{recipientId}', [ChatController::class, 'show'])->name('chat.messages');
    Route::get('/chat/api/messages/{recipientId}', [ChatController::class, 'getMessages'])->name('chat.api.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/conversations', [ChatController::class, 'conversations'])->name('chat.conversations');
    Route::delete('/chat/message/{messageId}', [ChatController::class, 'deleteMessage'])->name('chat.delete');
});

// Public portfolio routes - HARUS PALING AKHIR agar tidak bentrok dengan route yang lebih spesifik
Route::get('/portfolio/{portfolio}', [HomeController::class, 'show'])->name('portfolio.show');
Route::get('/user/{user}', [UserController::class, 'show'])->name('profile.show');

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggleBan', [AdminUserController::class, 'toggleBan'])->name('users.toggleBan');
    
    // Moderation routes
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/moderation/{portfolio}', [ModerationController::class, 'show'])->name('moderation.show');
    Route::post('/moderation/{portfolio}/flag', [ModerationController::class, 'flag'])->name('moderation.flag');
    Route::post('/moderation/{portfolio}/unflag', [ModerationController::class, 'unflag'])->name('moderation.unflag');
    Route::post('/moderation/{portfolio}/approve', [ModerationController::class, 'approve'])->name('moderation.approve');
    Route::post('/moderation/{portfolio}/reject', [ModerationController::class, 'reject'])->name('moderation.reject');
    Route::delete('/moderation/{portfolio}', [ModerationController::class, 'destroy'])->name('moderation.destroy');
});

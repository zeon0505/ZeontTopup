<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::get('/', function () {
    $data = \Illuminate\Support\Facades\Cache::remember('home_page_data', 600, function () {
        return [
            'games' => \App\Models\Game::where('is_active', true)->orderBy('sort_order')->get(),
            'banners' => \App\Models\Banner::where('is_active', true)->orderBy('sort_order')->orderBy('created_at', 'desc')->get(),
            'flashSales' => \App\Models\FlashSale::active()->with('product.game')->orderBy('end_time', 'asc')->get(),
            'news' => \App\Models\News::where('is_active', true)->orderBy('is_featured', 'desc')->latest()->take(3)->get(),
        ];
    });
    
    return view('welcome', $data);
});

Route::get('lang/{locale}', [\App\Http\Controllers\LocaleController::class, 'setLocale'])->name('locale.switch');

// Order Page
Route::get('/games', \App\Livewire\GameList::class)->name('games.index');
Route::get('/order/{game:slug}', \App\Livewire\GameOrder::class)->name('order.show'); // Fix: Ensure this uses GameOrder class
Route::get('/cek-transaksi', \App\Livewire\TransactionCheck::class)->middleware('throttle:transaction_search')->name('transaction.search');

// Features
Route::get('/kalkulator', \App\Livewire\Features\Calculator::class)->name('calculator.index');
Route::get('/leaderboard', \App\Livewire\Features\Leaderboard::class)->name('leaderboard');
Route::get('/news/{news:slug}', \App\Livewire\NewsShow::class)->name('news.show');
Route::get('/minigame', \App\Livewire\Features\FlappyGame::class)->name('minigame');

// User Dashboard
Route::get('dashboard', function () {
    if (Auth::user()->is_admin) {
        return redirect('/admin/dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Member Area
Route::middleware(['auth'])->group(function () {
    // Favorites
    Route::get('/favorites', \App\Livewire\Favorites::class)->name('favorites');
    
    // Profile & Settings
    Route::get('/profile', \App\Livewire\Member\ProfileSettings::class)->name('profile');
    
    // Deposit
    Route::get('/deposit', \App\Livewire\Member\DepositForm::class)->name('deposit');

    // Referral
    Route::get('/referral', \App\Livewire\Member\ReferralDashboard::class)->name('referral');
    Route::get('/loyalty', \App\Livewire\Member\LoyaltyPoints::class)->name('loyalty');
    Route::get('/notifications', \App\Livewire\Member\Notifications::class)->name('notifications');
});

// Admin Dashboard
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Games Management with separate pages
    Route::get('/games', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.games.index');
    })->name('admin.games.index');
    
    Route::get('/games/create', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.games.create');
    })->name('admin.games.create');
    
    Route::get('/games/{game}', function (\App\Models\Game $game) {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.games.show', compact('game'));
    })->name('admin.games.show');
    
    Route::get('/games/{game}/edit', function (\App\Models\Game $game) {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.games.edit', compact('game'));
    })->name('admin.games.edit');

    Route::get('/vouchers', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.games.index');
    })->name('admin.vouchers');
    
    // Flash Sales
    Route::get('/flash-sales', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.flash-sales');
    })->name('admin.flash-sales.index');

    // Products Management
    Route::get('/products', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.products.index');
    })->name('admin.products.index');

    Route::get('/products/{game}/manage', function (\App\Models\Game $game) {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.products.manage', compact('game'));
    })->name('admin.products.manage');

    Route::get('/products/create', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.products.create');
    })->name('admin.products.create');

    Route::get('/products/{product}/edit', function (\App\Models\Product $product) {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.products.edit', compact('product'));
    })->name('admin.products.edit');
    
    // Orders
    Route::get('/orders', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.orders');
    })->name('admin.orders');
    
    // Users
    Route::get('/users', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.users');
    })->name('admin.users');
    
    // API Settings
    Route::get('/api-settings', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.api');
    })->name('admin.api');
    // Payment Methods
    Route::get('/payment-methods', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.payment-methods');
    })->name('admin.payment-methods');

    Route::get('/banners', function () {
        abort_unless(auth()->user()->is_admin, 403);
        return view('admin.banners');
    })->name('admin.banners');

    // Flash Sales
    Route::get('/flash-sales', \App\Livewire\Admin\FlashSaleManager::class)
        ->name('admin.flash-sales');
    
    // Vouchers
    Route::get('/vouchers', \App\Livewire\Admin\VoucherManager::class)
        ->name('admin.vouchers');

    // Reviews
    Route::get('/reviews', \App\Livewire\Admin\ReviewManager::class)
        ->name('admin.reviews');

    // Referrals
    Route::get('/referrals', \App\Livewire\Admin\ReferralManager::class)
        ->name('admin.referrals');

    Route::get('/settings', \App\Livewire\Admin\SettingManager::class)->name('admin.settings');

    // News
    Route::get('/news', \App\Livewire\Admin\NewsManager::class)
        ->name('admin.news');

    Route::get('/verify-pin', \App\Livewire\Admin\PinVerify::class)->name('admin.pin.verify');
});



// Order Routes
Route::post('/order/create', [App\Http\Controllers\OrderController::class, 'store'])
    ->middleware('throttle:order_create')
    ->name('order.create');

Route::post('/payment/notification', [App\Http\Controllers\OrderController::class, 'notification'])
    ->name('payment.notification');

Route::get('/order/status/{orderNumber}', [App\Http\Controllers\OrderController::class, 'status'])
    ->name('order.status');

Route::post('/order/{orderNumber}/check-status', [App\Http\Controllers\OrderController::class, 'checkPaymentStatus'])
    ->name('order.checkStatus');

// Route khusus untuk simulasi pembayaran (Development only)
Route::post('/order/{orderNumber}/simulate-payment', [App\Http\Controllers\OrderController::class, 'simulatePayment'])
    ->name('order.simulatePayment');

require __DIR__.'/auth.php';

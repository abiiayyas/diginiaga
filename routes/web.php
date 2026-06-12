<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LPController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin,operator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    Route::resource('products', ProductController::class)->except(['show']);

    Route::get('landing-pages/{landingPage}/toggle', [LandingPageController::class, 'toggle'])
        ->name('landing-pages.toggle');
    Route::get('landing-pages/{landingPage}/stats', [LandingPageController::class, 'stats'])
        ->name('landing-pages.stats');
    Route::resource('landing-pages', LandingPageController::class)->except(['show']);

    Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('orders/supplier-queue', [OrderController::class, 'supplierQueue'])->name('orders.supplier-queue');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/tracking', [OrderController::class, 'updateTracking'])->name('orders.update-tracking');
    Route::patch('orders/{order}/supplier-ordered', [OrderController::class, 'markSupplierOrdered'])->name('orders.supplier-ordered');
    Route::post('orders/{order}/biteship', [OrderController::class, 'createBiteshipShipment'])->name('orders.biteship');
    Route::get('orders/{order}/copy-supplier-data', [OrderController::class, 'copySupplierData'])->name('orders.copy-supplier-data');
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit', 'destroy']);

    Route::get('notification-templates', [\App\Http\Controllers\Admin\NotificationTemplateController::class, 'index'])
        ->name('notification-templates');

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/campaigns', [AnalyticsController::class, 'campaigns'])->name('analytics.campaigns');
    Route::get('analytics/lp/{landingPage}', [AnalyticsController::class, 'lpDetail'])->name('analytics.lp');

    Route::resource('campaigns', CampaignController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/p/{slug}', [LPController::class, 'show'])->name('lp.show');

Route::post('/lp/create-order', [LPController::class, 'createOrder'])->name('lp.order.create');
Route::get('/lp/shipping-options', [LPController::class, 'getShippingOptions'])->name('lp.shipping');

Route::get('/checkout/form/{slug}', [CheckoutController::class, 'showForm'])->name('checkout.form');
Route::get('/checkout/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout/finish', [CheckoutController::class, 'finish'])->name('checkout.finish');
Route::get('/checkout/error', [CheckoutController::class, 'error'])->name('checkout.error');
Route::get('/checkout/pending', [CheckoutController::class, 'pending'])->name('checkout.pending');
Route::get('/checkout/cod/{order}', [CheckoutController::class, 'cod'])->name('checkout.cod');

Route::get('/track/{orderNumber}', [TrackingController::class, 'show'])->name('tracking.show');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.lookup');

Route::post('/webhook/midtrans', [\App\Http\Controllers\PaymentWebhookController::class, 'handle'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.midtrans');

require __DIR__.'/auth.php';

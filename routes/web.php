<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// SHOP (customer)
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\PrescriptionController as ShopPrescriptionController;
use App\Http\Controllers\Shop\PaymentProofController as ShopPaymentProofController;

// ADMIN
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PrescriptionReviewController;
use App\Http\Controllers\Admin\PaymentReviewController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MedicineController; // ⬅️ stok/obat

// =====================
// PUBLIC / AUTH
// =====================

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard'); // admin area
    }
    return redirect()->route('shop.index');          // katalog customer
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// ADMIN AREA
// =====================
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

    // Dashboard (hapus duplikasi Route::view)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Review Resep
    Route::get('/prescriptions',                       [PrescriptionReviewController::class,'index'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}',        [PrescriptionReviewController::class,'show'])->name('prescriptions.show');
    Route::post('/prescriptions/{prescription}/approve',[PrescriptionReviewController::class,'approve'])->name('prescriptions.approve');
    Route::post('/prescriptions/{prescription}/reject', [PrescriptionReviewController::class,'reject'])->name('prescriptions.reject');

    // Review Pembayaran
    Route::get('/payments',                    [PaymentReviewController::class,'index'])->name('payments.index');
    Route::get('/payments/{payment}',          [PaymentReviewController::class,'show'])->name('payments.show');
    Route::post('/payments/{payment}/approve', [PaymentReviewController::class,'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject',  [PaymentReviewController::class,'reject'])->name('payments.reject');

    // Manajemen Order
    Route::get('/orders',                 [AdminOrderController::class,'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');

    // Stok & Obat (BARU)
    Route::get('/medicines',                       [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create',                [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines',                      [MedicineController::class, 'store'])->name('medicines.store');
    Route::post('/medicines/{medicine}/add-stock', [MedicineController::class, 'addStock'])->name('medicines.addStock');
});

// =====================
// CUSTOMER / SHOP AREA
// =====================
Route::middleware(['auth','role:customer'])
    ->prefix('shop')->name('shop.')
    ->group(function () {

    // Katalog (hapus Route::view duplikat)
    Route::get('/',                 [CatalogController::class, 'index'])->name('index');
    Route::get('/product/{slug}',   [CatalogController::class, 'show'])->name('product.show');

    // Cart
    Route::get('/cart',             [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',        [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update',     [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove',     [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',      [CartController::class, 'clear'])->name('cart.clear');

    // Checkout & Order
    Route::get('/checkout',         [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout',        [CheckoutController::class, 'placeOrder'])->name('checkout.place');

    // Riwayat & Detail Pesanan
    Route::get('/orders',           [ShopOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',   [ShopOrderController::class, 'show'])->name('orders.show');

    // Upload Resep
    Route::get('/orders/{order}/prescription',  [ShopPrescriptionController::class,'create'])->name('prescriptions.create');
    Route::post('/orders/{order}/prescription', [ShopPrescriptionController::class,'store'])->name('prescriptions.store');

    // Upload Bukti Bayar
    Route::get('/orders/{order}/payment',  [ShopPaymentProofController::class,'create'])->name('payments.create');
    Route::post('/orders/{order}/payment', [ShopPaymentProofController::class,'store'])->name('payments.store');
});

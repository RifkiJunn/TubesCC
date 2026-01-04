<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (Marketplace + Lapak Saya) ---
Route::get('/dashboard', function () {
    $userId = Auth::id();
    $request = request();

    // 1. Ambil Barang Milik Sendiri
    $myProducts = Product::where('user_id', $userId)->latest()->get();

    // 2. Ambil Barang Orang Lain dengan Filter
    $query = Product::where('user_id', '!=', $userId)
                    ->where('status', 'available');

    // Filter: Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Filter: Location
    if ($request->filled('location')) {
        $query->where('campus_location', $request->location);
    }

    // Filter: Price Range
    if ($request->filled('price_range')) {
        $range = explode('-', $request->price_range);
        if (count($range) == 2) {
            $query->whereBetween('price', [(int)$range[0], (int)$range[1]]);
        }
    }

    // Sort
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'cheapest':
            $query->orderBy('price', 'asc');
            break;
        case 'expensive':
            $query->orderBy('price', 'desc');
            break;
        default:
            $query->latest();
            break;
    }

    $marketProducts = $query->get();

    return view('dashboard', compact('myProducts', 'marketProducts'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // --- PROFILE USER (Bawaan Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/location', [ProfileController::class, 'updateLocation'])->name('profile.location.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- FITUR BARANG (LUNGSURIN) ---

    // 1. Jual Barang Baru (Create & Store)
    Route::get('/jual-barang', [ProductController::class, 'create'])->name('products.create');
    Route::post('/jual-barang', [ProductController::class, 'store'])->name('products.store');

    // 2. Detail Barang (Show) - Saat gambar diklik
    Route::get('/barang/{product}', [ProductController::class, 'show'])->name('products.show');

    // 3. Edit Barang (Edit & Update) - [TAMBAHAN BARU]
    Route::get('/barang/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/barang/{product}', [ProductController::class, 'update'])->name('products.update');

    // 4. Beli Slot
    Route::get('/beli-slot', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/beli-slot/purchase', [SlotController::class, 'purchase'])->name('slots.purchase');
    Route::get('/beli-slot/success', [SlotController::class, 'success'])->name('slots.success');
});

// Midtrans Callback (tanpa auth)
Route::post('/midtrans/callback', [SlotController::class, 'callback'])->name('midtrans.callback');

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
});

require __DIR__.'/auth.php';
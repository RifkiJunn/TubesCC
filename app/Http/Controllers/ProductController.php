<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan Form Jual Barang
    public function create()
    {
        return view('products.create');
    }

    // Proses Simpan Barang Baru
    public function store(Request $request)
    {
        $user = Auth::user();

        // --- UPDATE LOGIKA: SLOT BASE SYSTEM ---
        
        // 1. Hitung barang yang sedang aktif dijual
        $usedSlots = $user->products()->where('status', 'available')->count();
        
        // 2. Ambil jatah slot user dari database (default 3)
        $limit = $user->product_limit; 

        // 3. Cek apakah slot sudah penuh?
        if ($usedSlots >= $limit) {
            return redirect()->route('dashboard')
                ->with('error', "Slot Penuh! Kuota kamu $limit barang. Beli slot tambahan untuk posting lagi.");
        }

        // 4. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'campus_location' => 'nullable|string', // Jadi opsional
            'province' => 'required|string',
            'city' => 'required|string',
        ]);

        // 5. Upload Gambar (Jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 6. Simpan ke Database
        Product::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'status' => 'available',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'campus_location' => $request->campus_location,
            'province' => $request->province,
            'city' => $request->city,
        ]);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diiklankan!');
    }

    // Menampilkan Detail Barang
    public function show(Product $product)
    {
        $product->load('user'); 
        return view('products.show', compact('product'));
    }

    // Menampilkan Form Edit
    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak berhak mengedit barang ini!');
        }

        return view('products.edit', compact('product'));
    }

    // Proses Simpan Perubahan (Update)
    public function update(Request $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];

        if ($request->hasFile('image')) {
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'Barang berhasil diperbarui!');
    }

    // Toggle Status Barang (Available <-> Sold) via Dashboard
    public function updateStatus(Request $request, Product $product)
    {
        if (Auth::id() !== $product->user_id) {
            abort(403);
        }

        // Validasi status yang dikirim 
        // (optional, bisa juga hardcode toggle saja)
        $newStatus = $product->status === 'available' ? 'sold' : 'available';
        
        $product->update(['status' => $newStatus]);

        return back()->with('success', 'Status barang berhasil diperbarui!');
    }
}
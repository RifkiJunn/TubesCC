<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SlotController extends Controller
{
    const SLOT_PRICE = 5000; // Rp 5.000 per slot

    public function index()
    {
        $user = Auth::user();
        $usedSlots = $user->products()->where('status', 'available')->count();
        $transactions = $user->transactions()->latest()->take(5)->get();
        
        return view('slots.index', [
            'user' => $user,
            'usedSlots' => $usedSlots,
            'slotPrice' => self::SLOT_PRICE,
            'transactions' => $transactions,
        ]);
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'slots' => 'required|integer|min:1|max:100',
        ]);

        $user = Auth::user();
        $slots = $request->slots;
        $amount = $slots * self::SLOT_PRICE;
        $orderId = 'SLOT-' . $user->id . '-' . time();

        // Simpan transaksi pending
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_id' => $orderId,
            'amount' => $amount,
            'slots_purchased' => $slots,
            'status' => 'pending',
        ]);

        // Buat Snap Token Midtrans
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
        
        $url = $isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'item_details' => [
                [
                    'id' => 'SLOT',
                    'price' => self::SLOT_PRICE,
                    'quantity' => $slots,
                    'name' => 'Slot Listing Barang',
                ],
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        $response = Http::withBasicAuth($serverKey, '')
            ->withoutVerifying() // Disable SSL untuk development
            ->post($url, $payload);

        if ($response->successful()) {
            $snapToken = $response->json('token');
            $transaction->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $orderId,
            ]);
        }

        return response()->json(['error' => 'Gagal membuat transaksi'], 500);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;

        // Validasi signature
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($signatureKey !== $expectedSignature) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $paymentType = $request->payment_type;

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($transaction->status !== 'success') {
                $transaction->update([
                    'status' => 'success',
                    'payment_type' => $paymentType,
                ]);
                
                // Tambah slot user
                $user = $transaction->user;
                $user->increment('product_limit', $transaction->slots_purchased);
            }
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaction->update([
                'status' => $transactionStatus,
                'payment_type' => $paymentType,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function success(Request $request)
    {
        $orderId = $request->order_id;
        $transaction = Transaction::where('order_id', $orderId)->first();

        if ($transaction && $transaction->status === 'pending') {
            // Cek status ke Midtrans
            $this->checkTransactionStatus($transaction);
        }

        return redirect()->route('slots.index')
            ->with('success', 'Pembayaran berhasil! Slot Anda telah ditambahkan.');
    }

    private function checkTransactionStatus(Transaction $transaction)
    {
        $serverKey = config('midtrans.server_key');
        $isProduction = config('midtrans.is_production');
        
        $url = $isProduction 
            ? "https://api.midtrans.com/v2/{$transaction->order_id}/status"
            : "https://api.sandbox.midtrans.com/v2/{$transaction->order_id}/status";

        $response = Http::withBasicAuth($serverKey, '')
            ->withoutVerifying()
            ->get($url);

        if ($response->successful()) {
            $data = $response->json();
            $status = $data['transaction_status'] ?? null;
            
            if (in_array($status, ['capture', 'settlement'])) {
                if ($transaction->status !== 'success') {
                    $transaction->update([
                        'status' => 'success',
                        'payment_type' => $data['payment_type'] ?? null,
                    ]);
                    
                    $transaction->user->increment('product_limit', $transaction->slots_purchased);
                }
            }
        }
    }
}

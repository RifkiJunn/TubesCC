<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of all users.
     * Supports search, filtering, and pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by subscription status
        if ($request->filled('subscription')) {
            if ($request->subscription === 'subscribed') {
                $query->where(function ($q) {
                    $q->where('product_limit', '>', 3)
                      ->orWhereHas('transactions', function ($t) {
                          $t->where('status', 'success');
                      });
                });
            } elseif ($request->subscription === 'not_subscribed') {
                $query->where(function ($q) {
                    $q->where('product_limit', '<=', 3)
                      ->whereDoesntHave('transactions', function ($t) {
                          $t->where('status', 'success');
                      });
                });
            }
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Order by newest first
        $query->latest();

        // Paginate with 20 items per page
        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user's details.
     */
    public function show(User $user)
    {
        // Load related data counts
        $user->loadCount(['products', 'transactions']);
        
        // Load transaction history (latest first)
        $user->load(['transactions' => function ($query) {
            $query->latest()->limit(10);
        }]);
        
        // Get last successful slot purchase
        $lastPurchase = $user->transactions()
            ->where('status', 'success')
            ->latest()
            ->first();
        
        return view('admin.users.show', compact('user', 'lastPurchase'));
    }
}

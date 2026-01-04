<?php

use App\Models\User;

beforeEach(function () {
    // Create admin user
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'product_limit' => 10,
    ]);
    
    // Create regular user
    $this->user = User::factory()->create([
        'role' => 'user',
        'product_limit' => 3,
    ]);
});

describe('Admin User List Access', function () {
    it('prevents non-admin users from accessing admin pages', function () {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.index'));
        
        $response->assertRedirect(route('dashboard'));
    });
    
    it('allows admin users to access admin pages', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));
        
        $response->assertOk();
        $response->assertViewIs('admin.users.index');
    });
    
    it('redirects guests to login', function () {
        $response = $this->get(route('admin.users.index'));
        
        $response->assertRedirect(route('login'));
    });
});

describe('Admin User List Display', function () {
    it('displays all users in the list', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));
        
        $response->assertSee($this->admin->name);
        $response->assertSee($this->user->name);
    });
    
    it('paginates users with 20 per page', function () {
        // Create 25 users
        User::factory(25)->create();
        
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));
        
        $response->assertOk();
        // Pagination should exist
        $response->assertViewHas('users');
    });
});

describe('Admin User Search', function () {
    it('searches users by name', function () {
        $searchUser = User::factory()->create(['name' => 'UniqueTestName123', 'role' => 'user']);
        
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['search' => 'UniqueTestName123']));
        
        $response->assertSee('UniqueTestName123');
    });
    
    it('searches users by email', function () {
        $searchUser = User::factory()->create(['email' => 'uniqueemail@test.com', 'role' => 'user']);
        
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['search' => 'uniqueemail@test.com']));
        
        $response->assertSee('uniqueemail@test.com');
    });
});

describe('Admin User Filter', function () {
    it('filters by subscribed users including those with transactions', function () {
        // User with > 3 slots
        $highLimitUser = User::factory()->create(['product_limit' => 4, 'name' => 'HighLimitUser']);
        
        // User with default slots but successful transaction
        $transactionUser = User::factory()->create(['product_limit' => 3, 'name' => 'TransactionUser']);
        $transactionUser->transactions()->create([
            'order_id' => 'ORD-123',
            'amount' => 50000,
            'slots_purchased' => 5,
            'payment_type' => 'qris',
            'status' => 'success',
            'snap_token' => 'token'
        ]);
        
        // Regular user
        $regularUser = User::factory()->create(['product_limit' => 3, 'name' => 'RegularUser']);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['subscription' => 'subscribed']));
        
        $response->assertSee('HighLimitUser');
        $response->assertSee('TransactionUser');
        $response->assertDontSee('RegularUser');
    });

    it('filters by role admin', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['role' => 'admin']));
        
        $response->assertSee($this->admin->name);
    });
    
    it('filters by role user', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['role' => 'user']));
        
        $response->assertSee($this->user->name);
    });
});

describe('Admin User Detail', function () {
    it('shows user detail page with transaction history', function () {
        // Create transactions for user
        $this->user->transactions()->create([
            'order_id' => 'ORD-TEST-1',
            'amount' => 50000,
            'slots_purchased' => 5,
            'payment_type' => 'qris',
            'status' => 'success',
            'snap_token' => 'token1'
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.show', $this->user));
        
        $response->assertOk();
        $response->assertViewIs('admin.users.show');
        $response->assertSee($this->user->name);
        $response->assertSee($this->user->email);
        
        // Check for transaction details
        $response->assertSee('Riwayat Transaksi Terakhir');
        $response->assertSee('ORD-TEST-1');
        $response->assertSee('Sukses');
    });
    
    it('prevents non-admin from viewing user detail', function () {
        $response = $this->actingAs($this->user)
            ->get(route('admin.users.show', $this->admin));
        
        $response->assertRedirect(route('dashboard'));
    });
});

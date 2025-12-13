<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah kolom No HP di tabel USERS
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
        });

        // Tambah kolom Lokasi Kampus di tabel PRODUCTS
        Schema::table('products', function (Blueprint $table) {
            $table->string('campus_location')->nullable()->after('price'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) { $table->dropColumn('phone'); });
        Schema::table('products', function (Blueprint $table) { $table->dropColumn('campus_location'); });
    }
};

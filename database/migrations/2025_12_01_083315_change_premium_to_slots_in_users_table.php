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
    Schema::table('users', function (Blueprint $table) {
        // Hapus kolom lama
        $table->dropColumn('is_premium'); 

        // Tambah kolom baru: Limit slot (Default 3 barang gratis)
        $table->integer('product_limit')->default(3)->after('email');
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('product_limit');
            $table->boolean('is_premium')->default(false);
        });
    }
};

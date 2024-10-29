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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // ID pembeli
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // ID produk perhiasan
            $table->integer('quantity'); // Jumlah produk yang dibeli
            $table->decimal('total_price', 15, 2); // Total harga
            $table->string('status')->default('pending'); // Status transaksi (e.g., pending, completed, cancelled)
            $table->timestamp('transaction_date')->useCurrent(); // Waktu transaksi
            $table->timestamps(); // Timestamps created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

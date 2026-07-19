<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->text('address');
            $table->string('phone', 20);
            $table->text('note')->nullable();
            $table->string('package_name');
            $table->decimal('product_price', 10, 2);
            $table->decimal('delivery_charge', 10, 2)->default(99);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'delivered', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

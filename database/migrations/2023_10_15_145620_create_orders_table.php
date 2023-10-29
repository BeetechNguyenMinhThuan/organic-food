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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_id');
            $table->timestamp('order_at');
            $table->tinyInteger('order_status');
            $table->tinyInteger('payment_method');
            $table->decimal('price');
            $table->decimal('sub_total')->nullable();
            $table->decimal('total_discount')->nullable();
            $table->decimal('total_price')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->decimal('ship_fee')->nullable();
            $table->text('user_comment')->nullable();
            $table->string('hash_order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

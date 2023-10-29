<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->string('hash_id')->nullable();
            $table->decimal('price');
            $table->integer('quantity');
            $table->decimal('sub_total')->nullable();
            $table->decimal('ship_fee')->nullable();
            $table->decimal('total_price')->nullable();
            $table->integer('status')->nullable();
            $table->integer('shipping_address_id');
            $table->string('cancel_reason')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};

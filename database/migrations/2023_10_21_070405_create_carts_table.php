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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('payment_method')->nullable();
            $table->tinyInteger('delivery_method')->nullable();
            $table->integer('discount_id')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('sub_total')->nullable();
            $table->decimal('total_price')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->decimal('ship_fee')->nullable();
            $table->integer('user_address_id')->nullable();
            $table->date('shipping_date')->nullable();
            $table->time('shipping_hours')->nullable();
            $table->integer('delivery_time')->nullable();
            $table->text('user_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

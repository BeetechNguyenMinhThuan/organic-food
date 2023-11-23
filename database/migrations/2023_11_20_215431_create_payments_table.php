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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->string('transaction_code')->nullable();
            $table->integer('user_id')->nullable();
            $table->float('money')->nullable();
            $table->string('note')->nullable();
            $table->string('vnpay_response_code')->nullable();
            $table->string('vnpay_code')->nullable();
            $table->string('bank_code')->nullable();
            $table->dateTime('p_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

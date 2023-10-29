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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('user_id');
            $table->tinyInteger('rating')->nullable();
            $table->dateTime('posted_date')->nullable();
            $table->text('comment');
            $table->tinyInteger('status')->nullable();
            $table->integer('censorship_user_id')->nullable();
            $table->integer('censorship_status')->nullable();
            $table->dateTime('censorship_date')->nullable();
            $table->dateTime('reply_date')->nullable();
            $table->text('reply_content')->nullable();
            $table->integer('reply_user_id')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};

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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('rate');
            $table->string('comment');
            $table->string('image');
            $table->timestamps();
            //fk
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('Cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('Cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
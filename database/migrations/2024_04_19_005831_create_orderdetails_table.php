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
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('order_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('total');
            $table->timestamps();
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('order_id')->references('order_id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderdetails');
    }
};

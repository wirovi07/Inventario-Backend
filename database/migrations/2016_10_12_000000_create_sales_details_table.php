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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('amount');
            $table->string('unit_price');
            $table->string('subtotal');
            $table->unsignedSmallInteger('sale_id')->unsigned(); 
            $table->foreign('sale_id')->references('id')->on('sales');
            $table->unsignedSmallInteger('product_id')->unsigned(); 
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};

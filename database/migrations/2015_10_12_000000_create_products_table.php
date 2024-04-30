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
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('description');
            $table->string('price');
            $table->string('inventory_quantity');
            $table->unsignedSmallInteger('company_id')->unsigned(); 
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedSmallInteger('supplier_id')->unsigned(); 
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('sales', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->date('date');
            $table->string('total');
            $table->unsignedSmallInteger('company_id')->unsigned(); 
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedSmallInteger('employee_id')->unsigned(); 
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedSmallInteger('customer_id')->unsigned(); 
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

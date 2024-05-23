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
        Schema::create('employees', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('employee_position');
            $table->date('hire_date');
            $table->double('salary');  
            $table->unsignedSmallInteger('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users');         
            $table->unsignedSmallInteger('company_id')->unsigned(); 
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

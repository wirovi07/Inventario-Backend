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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->enum('type_document', ['rc', 'ti', 'cc', 'ex'])->nullable();
            $table->string('document')->nullable()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['masculino', 'femenino'])->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

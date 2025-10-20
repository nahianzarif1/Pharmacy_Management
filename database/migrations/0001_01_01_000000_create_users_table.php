<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',50)->unique();
            $table->string('password'); // Breeze uses password
            $table->enum('role', ['admin','pharmacist','cashier'])->default('pharmacist');
            $table->string('full_name',100)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone', 30)->nullable();

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

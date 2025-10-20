<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('sku',50)->unique();
            $table->string('name',100);
            $table->string('generic_name',100)->nullable();
            $table->foreignId('medicine_type_id')->constrained('medicine_types')->onDelete('restrict');
            $table->string('unit',20);
            $table->string('strength',50)->nullable();
            $table->decimal('price_per_unit',10,2)->default(0);
            $table->integer('reorder_level')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

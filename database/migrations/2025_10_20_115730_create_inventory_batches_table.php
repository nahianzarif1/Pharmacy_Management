<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->string('batch_no',50);
            $table->integer('quantity')->unsigned()->default(0);
            $table->date('received_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('unit_cost',10,2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['medicine_id','batch_no']);
            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_batches');
    }
};

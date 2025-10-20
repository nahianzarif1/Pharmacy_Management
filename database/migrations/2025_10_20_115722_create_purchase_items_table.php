<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('restrict');
            $table->string('batch_no',50)->nullable();
            $table->integer('quantity')->unsigned();
            $table->decimal('unit_cost',10,2);
            $table->decimal('line_total',12,2)->virtualAs('quantity * unit_cost')->stored(); // if DB supports, else calculate in app
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};

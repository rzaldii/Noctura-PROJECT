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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('name', 100);
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->integer('sold')->default(0);
            $table->enum('status', ['coming_soon', 'available', 'sold_out'])->default('coming_soon');
            $table->integer('min_purchase')->default(1);
            $table->integer('max_purchase')->default(10);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

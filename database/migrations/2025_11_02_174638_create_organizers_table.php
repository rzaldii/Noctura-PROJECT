<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('username', 80)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('organization_name', 150);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestampsTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};

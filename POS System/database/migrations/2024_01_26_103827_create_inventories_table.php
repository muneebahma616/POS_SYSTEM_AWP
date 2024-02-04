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
        Schema::create('inventories', function (Blueprint $table) {
            // $table->id();
            $table->uuid('uuid')->default(\Illuminate\Support\Facades\DB::raw('UUID()'))->unique();
            $table->binary('conversionGrams', 10, 2); // Adjusted to use binary for grams
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

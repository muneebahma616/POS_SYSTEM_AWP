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
        Schema::create('venders', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->default(\Illuminate\Support\Facades\DB::raw('UUID()'))->unique();
            $table->string('venderName');
            $table->string('venderPhone');
            $table->integer('totalPurchasesAmount')->default(0)->nullable();
            $table->integer('totalPurchasesGrams')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venders');
    }
};

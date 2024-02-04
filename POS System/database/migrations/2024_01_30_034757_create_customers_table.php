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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->default(\Illuminate\Support\Facades\DB::raw('UUID()'))->unique();
            $table->string('customerName');
            $table->string('customerPhone');
            $table->integer('totalSalesAmount')->default(0)->nullable();
            $table->integer('totalSalesGrams')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

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
        Schema::create('legers', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->default(\Illuminate\Support\Facades\DB::raw('UUID()'))->unique();
            // $table->string('salesRecord_id');
            // $table->foreign('salesRecord_id')->references('uuid')->on('sales');

            // $table->string('pruchaseRecord_id');
            // $table->foreign('purchaseRecord_id')->references('uuid')->on('sales');
            $table->string('name');
            $table->string('phone');
            $table->integer('salesAmount')->default(0)->nullable();
            $table->integer('purchaseAmount')->default(0)->nullable();
            $table->integer('returnAmount')->default(0)->nullable();
            $table->integer('remainingAmount')->default(0)->nullable();
            $table->integer('goldKarat')->default(0)->nullable();
            $table->integer('TotalPrice')->default(0)->nullable();
            $table->binary('grams', 10, 2)->default(0)->nullable();
            $table->binary('Tax', 10, 2)->default(0)->nullable();
            $table->binary('Discount', 10, 2)->default(0)->nullable();

            $table->date("deliverydate")->nullable();
            // $table->binary('conversionGrams', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legers');
    }
};

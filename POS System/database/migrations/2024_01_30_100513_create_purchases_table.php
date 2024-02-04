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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('vendor_name');
            $table->string('vendor_phone');
            $table->string('payment_method');
            $table->binary('grams', 8, 2); // Adjusted to use binary for grams
            $table->string('goldKarat');
            $table->binary('price', 8, 2);
            $table->binary("Tax")->default(0)->nullable();
            $table->binary("Discount")->default(0)->nullable();
            $table->binary('total_price', 8, 2);

            $table->boolean("returned")->default(false);

            $table->uuid('vender_id');
            $table->foreign('vender_id')->references('uuid')->on('venders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

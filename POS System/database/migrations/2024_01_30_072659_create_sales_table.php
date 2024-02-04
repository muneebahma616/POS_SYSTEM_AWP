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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string("CustomerName");
            $table->string("CustomerPhone");
            $table->string("Salesman");
            $table->string('payment_method');
            $table->binary("DownPayment");
            $table->binary("RemainingPayment");
            $table->string("GoldKarat");
            $table->binary("Price");
            $table->binary("Grams");
            $table->binary("Tax")->default(0)->nullable();
            $table->binary("Discount")->default(0)->nullable();
            $table->binary("TotalPrice");
            $table->date("deliverydate");

            $table->boolean("returned")->default(false);

            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('uuid')->on('customers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

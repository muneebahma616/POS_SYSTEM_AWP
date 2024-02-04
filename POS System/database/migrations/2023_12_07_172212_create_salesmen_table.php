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
        Schema::create('salesmen', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(\Illuminate\Support\Facades\DB::raw('UUID()'))->unique();
            $table->string("name")->unique();
            $table->string("password");
            $table->string("salary");
            $table->string("phoneNumber");
            $table->string("salarystatus")->default("unpaid");
            $table->string("privilege")->default('employee');
            $table->date("salarypaiddate")->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salesmen');
    }
};

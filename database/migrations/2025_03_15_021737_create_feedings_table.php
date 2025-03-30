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
        Schema::disableForeignKeyConstraints();

        Schema::create('feedings', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['breast', 'bottle']);
            $table->enum('unit', ['ml', 'oz', 'min'])->default('min');
            $table->integer('amount');
            $table->enum('side', ['left', 'right', 'both'])->nullable();
            $table->dateTime('date_time');
            $table->foreignId('baby_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedings');
    }
};

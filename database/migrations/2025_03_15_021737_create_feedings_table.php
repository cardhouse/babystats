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
            $table->enum('type', ["breast","bottle"]);
            $table->enum('measurement', ["ml","oz","min"]);
            $table->string('size');
            $table->enum('side', ["left","right","both"])->nullable();
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

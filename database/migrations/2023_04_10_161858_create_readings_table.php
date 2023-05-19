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
        Schema::create('readings', function (Blueprint $table) {
            $table->id();
            $table->double('sensor_value');
            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');
            $table->unsignedBigInteger('helmet_id');
            $table->foreign('helmet_id')->references('id')->on('helmets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readings');
    }
};

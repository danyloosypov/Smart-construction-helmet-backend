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
        Schema::create('helmets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            //$table->unsignedBigInteger('worker_id');
            //$table->foreign('worker_id')->references('id')->on('workers')->onDelete('set null');
            $table->foreignId('worker_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helmets');
    }
};

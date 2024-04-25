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
        Schema::create('movement_histories', function (Blueprint $table) {
            $table->id();
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->string('category');
            $table->bigInteger('return_amount')->default(0);
            $table->bigInteger('auth'); 
            $table->timestamps();
            $table->unsignedBigInteger('id_movements');

            $table->foreign('id_movements')->references('id')->on('movements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_histories');
    }
};

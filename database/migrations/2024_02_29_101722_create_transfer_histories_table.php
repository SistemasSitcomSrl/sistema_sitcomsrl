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
        Schema::create('transfer_histories', function (Blueprint $table) {
            $table->id();          
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->bigInteger('return_amount')->default(0);
            $table->bigInteger('auth');
            $table->timestamps();
            $table->unsignedBigInteger('transfer_id');

            $table->foreign('transfer_id')->references('id')->on('trasnfers');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_histories');
    }
};

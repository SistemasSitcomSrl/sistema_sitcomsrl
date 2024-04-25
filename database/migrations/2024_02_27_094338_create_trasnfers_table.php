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
        Schema::create('trasnfers', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number');
            $table->bigInteger('branch_from_id');
            $table->bigInteger('branch_to_id');
            $table->bigInteger('user_from_id');
            $table->bigInteger('user_to_id');
            
            $table->date('departure_date');
            $table->time('departure_time');
            $table->bigInteger('missing_amount');
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->bigInteger('return_amount')->default(0);
            
           
            $table->boolean('state')->default(false);            
            $table->timestamps();            
            $table->unsignedBigInteger('id_inventory');
            $table->foreign('id_inventory')->references('id')->on('inventories');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trasnfers');
    }
};

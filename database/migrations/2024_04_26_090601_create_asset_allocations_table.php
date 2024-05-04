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
        Schema::create('asset_allocations', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number');
            $table->string('movement_type');
            $table->date('departure_date');
            $table->time('departure_time');
            $table->bigInteger('missing_amount');
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->bigInteger('return_amount')->default(0);
            $table->boolean('state')->default(0);
            $table->boolean('state_create')->default(0); 
            $table->bigInteger('branch_id');
            $table->bigInteger('auth');               
            $table->string('debline_text')->nullable();  
            $table->unsignedBigInteger('id_inventory');
            $table->unsignedBigInteger('id_worker');
            $table->timestamps();
            
            $table->foreign('id_inventory')->references('id')->on('inventories');
            $table->foreign('id_worker')->references('id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_allocations');
    }
};

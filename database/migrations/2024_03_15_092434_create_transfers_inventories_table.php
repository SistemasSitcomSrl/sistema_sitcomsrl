<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable();
            $table->bigInteger('id_inventory')->nullable();
            $table->bigInteger('custom_id')->nullable();
            $table->string('name_equipment')->nullable();
            $table->bigInteger('bar_Code')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->string('location')->nullable();
            $table->string('unit_measure')->nullable();
            $table->string('price')->nullable();
            $table->string('image_path')->nullable();
            $table->string('type');
            $table->string('debline_text')->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->bigInteger('state')->default(0);
            $table->bigInteger('state_exist')->default(0);
            $table->bigInteger('state_create');            
            $table->bigInteger('auth');  
            
            $table->unsignedBigInteger('branch_id')->default(1);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers_inventories');
    }
};

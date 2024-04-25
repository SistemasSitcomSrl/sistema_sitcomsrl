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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name_equipment');
            $table->bigInteger('bar_Code');
            $table->string('brand');
            $table->string('color');
            $table->bigInteger('amount');
            $table->string('location');
            $table->string('unit_measure');
            $table->string('price');
            $table->string('type');
            $table->string('state')->default(1);
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('branch_id')->default(1); // Clave foránea
            $table->timestamps();

            // Clave foránea que referencia al campo 'id' de la tabla 'branches'
            $table->foreign('branch_id')->references('id')->on('branches');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};

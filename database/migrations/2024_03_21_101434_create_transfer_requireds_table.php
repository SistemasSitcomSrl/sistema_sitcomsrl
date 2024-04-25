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
        Schema::create('transfer_requireds', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable(); //Numero de Recibo
            $table->bigInteger('custom_id')->nullable(); // Nro
            $table->bigInteger('amount')->nullable(); //Cantidad de Retiro
            $table->string('image_path')->nullable(); //Imagen del Retiro
            $table->bigInteger('state')->default(0); //Estado de la solicitud de retiro
            $table->string('state_request')->nullable();//Estado de la solicitud de retiro
            $table->bigInteger('auth'); //Usuario que esta realizando la baja
            $table->string('message'); //Mesanje de por que el retiro
            $table->string('message_request')->nullable(); //Mensaje de observaciones del administrador
            $table->unsignedBigInteger('id_inventory'); //A que sucursal pertence el encargado.
            $table->unsignedBigInteger('branch_id');

            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('id_inventory')->references('id')->on('inventories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_requireds');
    }
};

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('cuce'); 
            $table->string('type'); 
            $table->string('object');
            $table->string('entity');  
            $table->string('ubi_entity');
            $table->string('ubi_projects');         
            $table->date('date_opening');
            $table->date('date_notification');      
            $table->string('reference_price');            
            $table->boolean('state')->default(true);      
            $table->timestamps();
            $table->unsignedBigInteger('id_user');
            
            $table->foreign('id_user')->references('id')->on('users');
        });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

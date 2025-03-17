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
        Schema::create('recipe_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained('sectors');
            $table->foreignId('recipe_id')->constrained('recipe');
            $table->foreignId('ingredient_id')->constrained('ingredients');//huevos
            $table->integer('quantity');//3
            $table->string('presentation');//unidades1
            // precio_ingrediente/cantidad_ingrediente -> precio_unit * cantidad -> cost
            $table->double('cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_details');
    }
};

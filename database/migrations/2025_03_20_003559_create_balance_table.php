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
        Schema::create('balance', function (Blueprint $table) {
            $table->id();
            //De donde vino el dinero
            //vendimos 10 unidades de la receta
            $table->enum('movement', ['entrada', 'salida']); //
            $table->foreignId('recipe_id')->nullable()->constrained('recipe');
            $table->integer('quantity');
            //se pago tanto de tal ingrediente
            $table->foreignId('ingrediente_id')->nullable()->constrained('recipe');
            //se genero desde x registro
            $table->foreignId('storage_id')->nullable()->constrained('storage');
            //AUTOMATICO
            $table->string('description');
            //Manejo del dinero
            $table->float('balance'); // DINERO guardar con + || - 
            $table->float('current_balance');// RECUENTO
            $table->string('session', 10); //W0012025 
            $table->timestamps();
        });
    }

    /**
      * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance');
    }
};

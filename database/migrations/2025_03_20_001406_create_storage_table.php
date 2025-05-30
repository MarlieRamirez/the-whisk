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
        Schema::create('storage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained('ingredients');
            $table->foreignId('detail_id')->nullable()->constrained('recipe_details');
            $table->enum('movement', ['entrada', 'salida']);
            $table->string('description');
            $table->integer('quantity');
            $table->boolean('from');
            $table->float('total');//RECUENTO
            $table->string('session',10); //W012025
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage');
    }
};

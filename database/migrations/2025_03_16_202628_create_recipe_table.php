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
        Schema::create('recipe', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');//13
            $table->string('presentation'); // muffin
            $table->double('unit_price'); //whatever
            $table->double('batch_cost');// sum of every ingredient cost
            $table->double('unit_cost'); // batch_cost/quantity
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe');
    }
};

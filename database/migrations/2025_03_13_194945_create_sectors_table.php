<?php

use App\Models\Sector;
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
        //Schema::dropIfExists('sectors');
        
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Sector::factory()->createMany([
            ["name"=> 'Masa'],
            ["name"=> 'Relleno'],
            ["name"=> 'Frosting'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};

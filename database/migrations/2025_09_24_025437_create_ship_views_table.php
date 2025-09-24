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
        Schema::create('ship_views', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();                                      // description should allow longer text
            $table->year('build_year')->nullable();
            $table->integer('crew_number')->nullable();
            $table->integer('max_guests')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->string('zodiac_boats')->nullable();
            $table->integer('capacity')->nullable();
            $table->enum('comfort_level', ['standard', 'premium', 'luxury'])->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_views');
    }
};

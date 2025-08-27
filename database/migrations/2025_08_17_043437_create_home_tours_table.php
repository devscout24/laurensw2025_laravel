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
        Schema::create('home_tours', function (Blueprint $table) {
            $table->id();
            $table->string('label', 150);   // optional: add length limits
            $table->string('header', 150);   // optional: add length limits
            $table->string('title', 255);    // title might be long
            $table->string('duration', 50);  // e.g., "7 days, 6 nights"
            $table->string('ship', 100);     // ship name, better to limit
            $table->decimal('price', 10, 2); // price should be numeric, not string
            $table->string('image'); // price should be numeric, not string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_tours');
    }
};

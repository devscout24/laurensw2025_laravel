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
        Schema::create('itinerary_twos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trips_two_id')->constrained()->onDelete('cascade');
            $table->string('day')->nullable();
            $table->string('title')->nullable();
            $table->string('port')->nullable();
            $table->string('location')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_twos');
    }
};

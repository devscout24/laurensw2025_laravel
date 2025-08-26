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
        Schema::create('cabin_twos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trips_two_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('cabin_id')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->integer('cab_units')->default(0);
            $table->integer('ber_units')->default(0);
            $table->integer('male_units')->default(0);
            $table->integer('female_units')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabin_twos');
    }
};

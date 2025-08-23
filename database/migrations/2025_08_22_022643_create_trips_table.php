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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('highlights')->nullable();
            $table->longText('description')->nullable();
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('trip_code')->nullable();
            $table->string('availability')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('starting_city')->nullable();
            $table->string('finishing_city')->nullable();
            $table->string('starting_point')->nullable();
            $table->string('finishing_point')->nullable();
            $table->integer('duration')->nullable();
            $table->text('includes')->nullable();
            $table->text('excludes')->nullable();
            $table->string('supplier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};

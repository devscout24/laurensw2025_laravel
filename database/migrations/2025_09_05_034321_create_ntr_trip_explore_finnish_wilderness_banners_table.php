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
        Schema::create('ntr_trip_explore_finnish_wilderness_banners', function (Blueprint $table) {
            $table->id();
            $table->string('header');
            $table->string('image');
            $table->string('alt_tag')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ntr_trip_explore_finnish_wilderness_banners');
    }
};

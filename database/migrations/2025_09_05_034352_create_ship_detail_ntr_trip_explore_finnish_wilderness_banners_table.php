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
        Schema::create('ship_detail_ntr_trip_explore_finnish_wilderness_banners', function (Blueprint $table) {
            $table->id();
            $table->string('header');
            $table->string('title');
            $table->string('image');
            $table->string('alt_tag')->unique('alt_tag_unique')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_detail_ntr_trip_explore_finnish_wilderness_banners');
    }
};

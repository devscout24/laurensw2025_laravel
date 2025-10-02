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
        Schema::create('our_missions', function (Blueprint $table) {
            $table->id();
            $table->string('header');
            $table->string('title');
            $table->text('description');
            $table->string('image_1');
            $table->string('image_2');
            $table->string('alt_tag1')->unique()->nullable();
            $table->string('alt_tag2')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('our_missions');
    }
};

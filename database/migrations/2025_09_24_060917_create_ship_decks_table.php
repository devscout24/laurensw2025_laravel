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
        Schema::create('ship_decks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipview_id')
                ->constrained('ship_views')
                ->onDelete('cascade'); // deletes decks if shipview deleted
            $table->string('image')->nullable();
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_decks');
    }
};

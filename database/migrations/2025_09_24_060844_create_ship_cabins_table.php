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
        Schema::create('ship_cabins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipview_id')
                ->constrained('ship_views')
                ->onDelete('cascade'); // deletes cabins if shipview deleted
            $table->enum('cabin_type', ['oceanview', 'balcony', 'interior', 'royalsuite']);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ship_cabins');
    }
};

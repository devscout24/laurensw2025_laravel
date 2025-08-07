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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Name of the person giving the rating
            $table->string('designation')->nullable(); // Optional, can be nullable if not always needed
            $table->text('description');             // Review or feedback text
            $table->string('image');             // Review or feedback text
            $table->decimal('rating', 2, 1);           // e.g., 4.5 stars; supports 1 decimal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};

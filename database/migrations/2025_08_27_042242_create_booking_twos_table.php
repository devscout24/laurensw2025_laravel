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
        Schema::create('booking_twos', function (Blueprint $table) {
            $table->id();
            // Who booked + which trip/cabin
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trips_two_id')->constrained('trips_twos')->cascadeOnDelete();
            $table->foreignId('cabin_two_id')->nullable()->constrained('cabin_twos')->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_twos');
    }
};

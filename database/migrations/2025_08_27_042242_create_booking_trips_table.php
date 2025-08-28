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
        Schema::create('booking_trips', function (Blueprint $table) {
            $table->id();
            // Who booked + which trip/cabin
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //For Trips api
            $table->foreignId('trip_id')->nullable()->constrained('trips')->nullOnDelete();
            $table->foreignId('ship_id')->nullable()->constrained('ships')->nullOnDelete();
            $table->foreignId('cabin_id')->nullable()->constrained('cabins')->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->string('number_of_members')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('street_house_number')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('city_place_name')->nullable();
            $table->string('stay_at_home_contact')->nullable();
            $table->string('contact_no_home_caller')->nullable();
            $table->enum('room_preference', ['1', '2', '3', '4'])->nullable()->default('1');
            $table->enum('travel_insurance', ['yes', 'no'])->default('yes');
            $table->string('insured_at')->nullable();
            $table->string('policy_number')->nullable();
            $table->text('additional_note')->nullable();
            $table->boolean('terms_condition_check')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_trips');
    }
};

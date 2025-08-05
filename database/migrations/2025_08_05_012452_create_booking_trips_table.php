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
            $table->string('trip_id');
            $table->string('number_of_members')->nullable();
            $table->date('trip_date');
            $table->string('name');
            $table->string('surname');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('mobile');
            $table->string('email');
            $table->string('street_house_number');
            $table->string('country')->nullable();
            $table->string('post_code');
            $table->string('city_place_name');
            $table->string('stay_at_home_contact');
            $table->string('contact_no_home_caller');
            $table->enum('room_preference', ['1 person', '2/3 person'])->nullable();
            $table->unsignedBigInteger('room_category_id')->nullable();
            $table->enum('travel_insurance', ['yes', 'no'])->default('yes')->nullable();
            $table->string('insured_at');
            $table->string('policy_number');
            $table->text('additional_note')->nullable();
            $table->boolean('terms_condition_check ', false)->nullable();
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

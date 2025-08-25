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
        Schema::create('trips_twos', function (Blueprint $table) {
            $table->id();
            $table->string('region')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('external_id')->unique(); // id from API
            $table->string('code')->nullable();
            $table->boolean('combination')->default(false);
            $table->boolean('only_in_combination')->default(false);
            $table->boolean('translated')->default(false);
            $table->date('departure_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('name')->nullable();
            $table->text('summary')->nullable();
            $table->string('embark')->nullable();
            $table->string('disembark')->nullable();
            $table->string('dr_usp')->nullable();
            $table->text('trip_included')->nullable();
            $table->text('trip_excluded')->nullable();
            $table->integer('days')->nullable();
            $table->integer('nights')->nullable();
            $table->unsignedBigInteger('ship_id')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('map')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips_twos');
    }
};

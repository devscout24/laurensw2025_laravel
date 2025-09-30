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
        Schema::create('seo_titles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('language_code', ['EN', 'NL']); // store 'EN' or 'NL'
            $table->timestamps();

            // Foreign key to languages.code (no cascade on delete)
            $table->foreign('language_code')
                ->references('code')
                ->on('languages')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_titles');
    }
};

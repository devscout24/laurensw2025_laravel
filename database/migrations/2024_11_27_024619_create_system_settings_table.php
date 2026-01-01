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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_title')->nullable();
            $table->string('system_short_title')->nullable();
            $table->string('logo')->default('uploads/systems/logo/logo.png');
            $table->string('minilogo')->default('uploads/systems/logo/minilogo.png');
            $table->string('favicon')->default('uploads/systems/favicon/favico.png');
            $table->string('company_name')->nullable();
            $table->text('tag_line')->nullable();
            $table->string('phone_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('time_zone')->nullable();
            $table->string('language')->nullable();
            $table->text('copyright_text')->nullable();
            $table->string('admin_title')->nullable();
            $table->string('admin_short_title')->nullable();
            $table->string('admin_logo')->default('uploads/systems/logo/logo.png');
            $table->string('admin_mini_logo')->default('uploads/systems/logo/minilogo.png');
            $table->string('admin_favicon')->default('uploads/systems/favicon/favico.png');
            $table->text('admin_copyright_text')->nullable();
            $table->string('googlemap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};

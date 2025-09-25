<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true); // Ensure id is unsignedBigInteger
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('slug')->unique();
            $table->string('email', 100)->unique();
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('license_number', 50)->nullable();
            $table->string('agency_name', 100)->nullable();
            $table->string('office_address', 255)->nullable();
            $table->date('join_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('profile_picture_url', 255)->nullable(); // Add profile picture field
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agents');
    }
};
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
        Schema::create('properties', function (Blueprint $table) {
            $table->id(); // Changed from property_id to id for consistency
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('property_type', ['Residential', 'Commercial', 'Industrial', 'Land', 'Mixed-Use']);
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state_province');
            $table->string('zip_postal_code');
            $table->string('country');
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->decimal('price', 15, 2);
            $table->string('currency', 3)->default('INR');
            $table->decimal('area_sqft', 10, 2)->nullable();
            $table->decimal('area_sqm', 10, 2)->nullable();
            $table->integer('number_of_bedrooms')->nullable();
            $table->decimal('number_of_bathrooms', 3, 1)->nullable();
            $table->integer('year_built')->nullable();
            $table->enum('listing_status', ['For Sale', 'For Rent', 'Sold', 'Leased', 'Pending']);
            $table->date('date_listed');
            $table->timestamp('last_updated')->useCurrent()->useCurrentOnUpdate();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('owners')->nullOnDelete();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('properties');
    }
};
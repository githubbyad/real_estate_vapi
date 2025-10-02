<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Agent;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence) . '-' . time(),
            'description' => $this->faker->paragraph,
            'property_type' => $this->faker->randomElement(['Residential', 'Commercial', 'Industrial', 'Land', 'Mixed-Use']),
            'address_line1' => $this->faker->streetAddress,
            'address_line2' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state_province' => $this->faker->state,
            'zip_postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'price' => $this->faker->randomFloat(2, 50000, 1000000),
            'currency' => 'USD',
            'area_sqft' => $this->faker->randomFloat(2, 500, 5000),
            'area_sqm' => $this->faker->randomFloat(2, 50, 500),
            'number_of_bedrooms' => $this->faker->numberBetween(1, 5),
            'number_of_bathrooms' => $this->faker->randomFloat(1, 1, 3),
            'year_built' => $this->faker->year,
            'listing_status' => $this->faker->randomElement(['For Sale', 'For Rent', 'Sold', 'Leased', 'Pending']),
            'date_listed' => $this->faker->date,
            'agent_id' => Agent::factory(),
            'owner_id' => Owner::factory(),
        ];
    }
}
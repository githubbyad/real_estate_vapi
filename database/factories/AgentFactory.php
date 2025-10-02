<?php

namespace Database\Factories;

use App\Models\Agent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $fullName = "$firstName $lastName";

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'slug' => Str::slug($fullName),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'license_number' => $this->faker->unique()->numerify('LIC-#####'),
            'agency_name' => $this->faker->company,
            'office_address' => $this->faker->address,
            'join_date' => $this->faker->date,
            'is_active' => $this->faker->boolean,
            'profile_picture_url' => $this->faker->imageUrl,
            'bio' => $this->faker->paragraph,
        ];
    }
}
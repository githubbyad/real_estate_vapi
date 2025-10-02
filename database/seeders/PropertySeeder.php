<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Agent;
use App\Models\Owner;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::factory()
            ->count(50)
            ->create()
            ->each(function ($property) {
                $property->agent_id = Agent::inRandomOrder()->first()->id;
                $property->owner_id = Owner::inRandomOrder()->first()->id;
                $property->save();
            });
    }
}
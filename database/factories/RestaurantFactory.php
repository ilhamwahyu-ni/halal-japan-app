<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Restaurant;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address,
            'city_id' => City::factory(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'status' => $this->faker->randomElement(["open", "closed"]),
            'website' => $this->faker->domainName(),
        ];
    }
}

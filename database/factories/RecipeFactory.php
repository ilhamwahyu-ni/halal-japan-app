<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Recipe;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $this->faker->addProvider(FakerPicsumImagesProvider::class);
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'image' => $this->faker->imageUrl(width: 300, height: 150,),
            'status' => $this->faker->randomElement(["active", "inactive"]),
            'video' => $this->faker->word(),
            'ingridients' => $this->faker->text(),
            'allergens' => $this->faker->text(),
        ];
    }
}

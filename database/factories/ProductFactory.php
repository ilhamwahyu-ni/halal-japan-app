<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Product;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $this->faker->addProvider(FakerPicsumImagesProvider::class);
        return [
            'name' => $this->faker->name(),
            'barcode' => $this->faker->ean13(),
            'ingridients' => $this->faker->text(),
            'allergens' => $this->faker->text(),
            'image' => $this->faker->imageUrl(width: 300, height: 150,),
            'status' => $this->faker->randomElement(["haram", "no-contamination", "halal"]),
            'company_id' => Company::factory(),
        ];
    }
}

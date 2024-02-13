<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $files = scandir('public/images/');
        $files = array_diff($files, array('.', '..'));
        $imagePath = 'images/' . $this->faker->randomElement($files);


        return [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(100000, 2000000),
            'image_path' => $imagePath,
            'discountable' => $this->faker->boolean,
        ];
    }
}

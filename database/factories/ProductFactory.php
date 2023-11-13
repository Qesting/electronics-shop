<?php

namespace Database\Factories;

use App\Http\Controllers\CategoryDetailsController;
use App\Models\Category;
use App\Models\Image;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Render properties into name.
     *
     * @param array $properties
     * @param string $name
     *
     * @return string
     */
    protected function propsInName(array $properties, string $name): string
    {
        if (count($properties) === 0) return $name;
        $renderedProperties = [];
        foreach ($properties as $key => $propertyValue) {
            [
                'value' => $value,
                'display' => $display,
            ] = $propertyValue;
            $unit = $propertyValue['unit'] ?? '';
            if ($display !== true) continue;

            $renderedProperties[$key] = $value.$unit;
        }
        return $name.' '.implode(' ', $renderedProperties);
    }

    /**
     * Render product name based on its parent Category.
     *
     * @param App\Models\Category $category
     * @param array $properties
     *
     * @return string
     */
    protected function renderName(Category $category, array $properties): string
    {
        $words = explode(' ', $category->name);
        $replacement = '';
        if ($category->topLevelParent()->grammatical_gender == 'M') {
            $words[0] = mb_substr($words[0], 0, mb_strlen($words[0]) - 1);
            $replacement = 'y';
        } else {
            $words[0][mb_strlen($words[0]) - 1] = 'a';
            $replacement = 'a';
        }
        for ($index = 1; $index < count($words); $index++) {
                $word = &$words[$index];
                $word = preg_replace('/[aąeęioóuy]$/i', $replacement, $word);
            }
        $name =  implode(' ', $words);

        return $this->propsInName($properties, $name);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warranty_period' => rand(2, 6),
            'number_in_stock' => rand(100, 1000)
        ];
    }

    /**
     * Further configure the model's state after receiving all properties.
     *
     * @return Database\Factories\ProductFactory
     */
    public function configure(): ProductFactory
    {
        return $this->afterMaking(function (Product $product) {
            $category = $product->category ?? Category::isLeaf()->inRandomOrder()->first();
            $manufacturer = $product->manufacturer ?? Manufacturer::inRandomOrder()->first();
            $directives = CategoryDetailsController::matchDirectives($category);
            $properties = CategoryDetailsController::randomizeProperties($directives);
            $price = array_splice($properties, 0, 1)['price']['value'];
            $name = $this->renderName($category, $properties);

            $product->category()->associate($category);
            $product->manufacturer()->associate($manufacturer);

            $product->name = $name;
            $product->details = json_encode($properties);
            $product->price = $price;
            $product->save();

            $limit = rand(1, 3);
            $images = new Collection();
            for ($index = 0; $index < $limit; $index++) {
                $image = new Image();
                $image->origin = 'https://placehold.co/';
                $image->name = '200?text=' . $index;
                if ($index === 0) $image->thumbnail = true;
                $images->push($image);
            }
            $product->images()->saveMany($images);

        });
    }
}

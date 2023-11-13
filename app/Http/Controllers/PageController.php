<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Retrieve all categories.
     *
     * @return Illuminate\Database\Eloquent\Collection<Category>
     */
    public function categories(): Collection
    {
        return Category::with(['image'])->tree()->get()->toTree();
    }

    /**
     * Retrieve the products for the specified category.
     *
     * @param App\Models\Category $category
     *
     * @return Illuminate\Database\Eloquent\Collection<Product>
     */
    public function products(Category $category, ?string $filters = null): Collection
    {
        $products = Product::with([
            'manufacturer' => function (BelongsTo $query) {
                $query->select('id', 'name');
            },
            'sales' => function (BelongsToMany $query) {
                $query->latest()->take(1);
            },
            'images' => function (MorphMany $query) {
                $query->where('thumbnail', '=', true);
            }
        ])->whereBelongsTo($category);

        if (!is_null($filters)) {
            $filterArray = json_decode($filters, true);
            foreach ($filterArray as $filterKey => $filter) {
                $jsonPath = "details->{$filterKey}->value";
                if (isset($filter['max']) || isset($filter['min'])) {
                    $min = $filter['min'] ?? PHP_INT_MIN;
                    $max = $filter['max'] ?? PHP_INT_MAX;
                    if ($filterKey === 'price') {
                        $products = $products->whereBetween('price', [$min, $max]);
                    } else {
                        $products = $products->whereRaw(
                            "CAST( JSON_EXTRACT(`details`, '$.{$filterKey}.value') AS DOUBLE) BETWEEN {$min} AND {$max}"
                        );
                    }
                } else {
                    $products = $products->whereIn($jsonPath, $filter);
                }
            }
        }

        return $products->get([
            'id',
            'name',
            'price',
            'manufacturer_id'
        ]);
    }

    /**
     * Retrieve a single product.
     *
     * @param int $id
     *
     * @return App\Models\Product
     */
    public function product(int $productId): Product
    {
        return Product::with([
            'manufacturer' => function (BelongsTo $query) {
                $query->select('id', 'name');
            },
            'sales' => function (BelongsToMany $query) {
                $query->latest()->take(1);
            },
            'images' => function (MorphMany $query) {
                $query->orderByDesc('thumbnail')->orderBy('id');
            },
            'category',
            'reviews'
        ])->findOrFail($productId);
    }

    /**
     * Retrieve 10 newest products.
     *
     * @return Illuminate\Database\Eloquent\Collection<Product>
     */
    public function newProducts(): Collection
    {
        return Product::with([
            'manufacturer' => function (BelongsTo $query) {
                $query->select('id', 'name');
            },
            'sales' => function (BelongsToMany $query) {
                $query->latest()->take(1);
            },
            'images' => function (MorphMany $query) {
                $query->where('thumbnail', '=', true);
            }
        ])->latest()->take(10)->get([
            'id',
            'name',
            'price',
            'manufacturer_id'
        ]);
    }

    /**
     * Retrieve 4 or less current sales.
     *
     * @return Illuminate\Database\Eloquent\Collection<Sale>
     */
    public function currentSales(): Collection
    {
        return Sale::with(['image'])->latest()->take(4)->get();
    }

    /**
     * Render the index page.
     *
     * @return Inertia\Response
     */
    public function indexPage(): Response
    {
        return Inertia::render('Index', [
            'categories' => $this->categories(),
            'newProducts' => $this->newProducts(),
            'sales' => $this->currentSales()
        ]);
    }

    /**
     * Render the specified category page.
     *
     * @param int $categoryId
     *
     * @return Inertia\Response
     */
    public function categoryPage(int $categoryId, ?string $filters = null): Response
    {
        $category = Category::findOrFail($categoryId);

        return Inertia::render(
            'Category',
            [
                'categories' => $this->categories(),
                'category' => $category,
                'properties' => CategoryDetailsController::getPropertyRanges($category),
                'products' => $this->products($category, $filters)
            ]
        );
    }

    /**
     * Render the specified product page.
     *
     * @param int $productId
     *
     * @return Inertia\Response
     */
    public function productPage(int $productId): Response
    {
        return Inertia::render(
            'Product',
            [
                'product' => $this->product($productId)
            ]
            );
    }
}

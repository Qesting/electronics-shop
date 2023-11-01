<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    /**
     * Retrieves a signle product from DB.
     *
     * @param int $id
     *
     * @return Inertia\Response
     */
    public function retrieve(int $id): Response
    {
        return Inertia::render(
            'Product',
            [
                'product' => Product::with([
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
                ])->findOrFail($id)
            ]
        );
    }

    /**
     * Retrieves all products belonging to the specified category.
     *
     * @param int $categoryId
     *
     * @return Inertia\Response
     */
    public function retrieveCategory(int $categoryId): Response
    {
        return Inertia::render(
            'Category',
            [
                'products' => Product::with([
                    'manufacturer' => function (BelongsTo $query) {
                        $query->select('id', 'name');
                    },
                    'sales' => function (BelongsToMany $query) {
                        $query->latest()->take(1);
                    },
                    'images' => function (MorphMany $query) {
                        $query->where('thumbnail', '=', true);
                    }
                ])->whereBelongsTo(
                    Category::findOrFail($categoryId)
                )->get([
                    'id',
                    'name',
                    'price',
                    'manufacturer_id'
                ])
            ]
        );
    }
}

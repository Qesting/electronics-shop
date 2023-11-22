<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageHelperController extends Controller
{
    /**
     * Retrieve all categories.
     *
     * @return Illuminate\Database\Eloquent\Collection<App\Models\Category>
     */
    public static function categories(): Collection
    {
        return Category::with(['image'])->tree()->get()->toTree();
    }

    /**
     * Retrieve the products for the specified category.
     *
     * @param App\Models\Category $category
     *
     * @return Illuminate\Database\Eloquent\Collection<App\Models\Product>
     */
    public static function categoryProducts(Category $category, ?array $filters = null): Collection
    {
        $products = Product::with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name');
            },
            'sales' => function ($query) {
                $query->latest()->take(1);
            },
            'images' => function ($query) {
                $query->where('thumbnail', '=', true);
            }
        ])->whereBelongsTo($category);

        if (!is_null($filters)) {
            foreach ($filters as $filterKey => $filter) {
                if ($filter === []) continue;
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
                    if ($filterKey === 'manufacturer') {
                        $products = $products->whereHas('manufacturer', fn ($query) => $query->whereIn('name', $filter));
                    } else {
                        $products = $products->whereIn($jsonPath, $filter);
                    }
                }
            }
        }

        return $products->where('number_in_stock', '>', 0)->get([
            'id',
            'name',
            'price',
            'manufacturer_id',
            'number_in_stock'
        ]);
    }

    /**
     * Retrieve a single product.
     *
     * @param int $id
     *
     * @return App\Models\Product
     */
    public static function product(int $productId): Product
    {
        return Product::with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name');
            },
            'sales' => function ($query) {
                $query->latest()->take(1);
            },
            'images' => function ($query) {
                $query->orderByDesc('thumbnail')->orderBy('id');
            },
            'category',
            'reviews',
            'reviews.user.customer'
        ])->findOrFail($productId);
    }

    /**
     * Retrieve a few products by ids.
     *
     * @param iterable $productIds
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function products(iterable $productIds): \Illuminate\Database\Eloquent\Collection
    {
        return Product::with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name');
            },
            'sales' => function ($query) {
                $query->latest()->take(1);
            },
            'images' => function ($query) {
                $query->where('thumbnail', '=', true);
            }
        ])->whereIn('id', $productIds)->where('number_in_stock', '>', 0)->get([
            'id',
            'name',
            'price',
            'manufacturer_id',
            'number_in_stock'
        ]);
    }

    /**
     * Retrieve 10 newest products.
     *
     * @return Illuminate\Database\Eloquent\Collection<App\Models\Product>
     */
    public static function newProducts(): Collection
    {
        return Product::with([
            'manufacturer' => function ($query) {
                $query->select('id', 'name');
            },
            'sales' => function ($query) {
                $query->latest()->take(1);
            },
            'images' => function ($query) {
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
     * @return Illuminate\Database\Eloquent\Collection<App\Models\Sale>
     */
    public static function currentSales(): Collection
    {
        return Sale::with(['image'])->latest()->take(4)->get();
    }

    public static function cartItems(Request $request): Collection
    {
        $productList = $request->session()->get('cart') ?? [];
        $products =  self::products(array_keys($productList));
        $products->each(fn (Product $product) => $product->quantity = $productList[$product->id]);
        return $products;
    }

    /**
     * Retrieve all payment methods.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function paymentMethods(): Collection
    {
        return \App\Models\PaymentMethod::all();
    }

    /**
     * Retrieve all shipping methods.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function shippingMethods(): Collection
    {
        return \App\Models\ShippingMethod::with(['shipper'])->get();
    }

    /**
     * Retrieve customer shipping data from currently logged in or session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Customer
     */
    public static function customerData(Request $request): \App\Models\Customer
    {
        return Auth::check()
            ? Auth::user()->customer()->with(['address'])->first()
            : $request->session()->get('customer', new \App\Models\Customer);
    }

    /**
     * Utility: convert array key case to camelCase.
     *
     * @param iterable $array
     *
     * @return array
     */
    public static function arrayToCamelCase(iterable $array): array
    {
        $returnValue = [];

        foreach ($array as $key => $value) {
            $returnValue[
                \Illuminate\Support\Str::camel($key)
            ] = is_array($value)
                ? self::arrayToCamelCase($value)
                : $value;
        };
        return $returnValue;
    }

    /**
     * Retrieve the given sale.
     *
     * @param int $saleId
     *
     * @return \App\Models\Sale
     */
    public static function sale(int $saleId): Sale
    {
        return Sale::with([
            'products',
            'products.manufacturer' => function ($query) {
                $query->select('id', 'name');
            },
            'products.images' => function ($query) {
                $query->where('thumbnail', '=', true);
            },
            'image'
        ])->findOrFail($saleId);
    }
}

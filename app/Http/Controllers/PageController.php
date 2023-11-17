<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Render the index page.
     *
     * @return Inertia\Response
     */
    public function indexPage(): Response
    {
        return Inertia::render('Index', [
            'categories' => PageHelperController::categories(),
            'newProducts' => PageHelperController::newProducts(),
            'sales' => PageHelperController::currentSales()
        ]);
    }

    /**
     * Render the specified category page.
     *
     * @param int $categoryId
     *
     * @return Inertia\Response
     */
    public function categoryPage(int $categoryId): Response
    {
        $category = Category::findOrFail($categoryId);

        return Inertia::render(
            'Category',
            [
                'categories' => PageHelperController::categories(),
                'category' => $category,
                'properties' => CategoryDetailsController::getPropertyRanges($category),
                'products' => PageHelperController::products($category)
            ]
        );
    }

    /**
     * Render the specified category page.
     *
     * @param int $categoryId
     *
     * @return Inertia\Response
     */
    public function filteredCategoryPage(Request $request, int $categoryId): Response
    {
        $category = Category::findOrFail($categoryId);
        $filters = $request->all();

        return Inertia::render(
            'Category',
            [
                'categories' => PageHelperController::categories(),
                'category' => $category,
                'properties' => CategoryDetailsController::getPropertyRanges($category),
                'products' => PageHelperController::products($category, $filters)
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
                'categories' => PageHelperController::categories(),
                'product' => PageHelperController::product($productId)
            ]
        );
    }

    /**
     * Render the cart page.
     *
     * @param int $productId
     *
     * @return Inertia\Response
     */
    public function cartPage(Request $request): Response
    {
        return Inertia::render(
            'Cart',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'code' => (new CartController)->code($request)
            ]
        );
    }
}

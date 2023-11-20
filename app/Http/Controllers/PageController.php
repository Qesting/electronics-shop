<?php

namespace App\Http\Controllers;

use \App\Models\Category;
use \Illuminate\Http\Request;
use \Inertia\Inertia;
use \Inertia\Response;
use \Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Render the index page.
     *
     * @return \Inertia\Response
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
     * @return \Inertia\Response
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
     * @return \Inertia\Response
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
     * @return \Inertia\Response
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
     * @param \Illuminate\Http\Request
     *
     * @return \Inertia\Response
     */
    public function cartPage(Request $request): Response
    {
        return Inertia::render(
            'Cart',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'code' => CartController::code($request)
            ]
        );
    }

    /**
     * Render the checkout page.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Inertia\Response
     */
    public function checkoutPage(Request $request): Response
    {
        $customerData = PageHelperController::arrayToCamelCase(
            PageHelperController::customerData($request)->toArray()
        );

        return Inertia::render(
            'Checkout',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'notLoggedIn' => !Auth::check(),
                'shippingMethods' => PageHelperController::shippingMethods(),
                'paymentMethods' => PageHelperController::paymentMethods(),
                'customerData' => $customerData
            ]
        );
    }

    /**
     * Render the end checkout page.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Inertia\Response
     */
    public function endCheckoutPage(Request $request): Response
    {
        $customerData = PageHelperController::arrayToCamelCase(
            PageHelperController::customerData($request)->toArray()
        );

        $orderMethods = PageHelperController::arrayToCamelCase(
            CartController::saveShippingData($request)
        );

        return Inertia::render(
            'EndCheckout',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'customerData' => $customerData,
                'orderMethods' => $orderMethods
            ]
        );
    }
}

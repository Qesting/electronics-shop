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
                'products' => PageHelperController::categoryProducts($category)
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
                'products' => PageHelperController::categoryProducts($category, $filters)
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
    public function cartPage(\App\Http\Requests\DiscountCodeRequest $request): Response
    {
        return Inertia::render(
            'Cart',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'discountCode' => CartController::code($request)
            ]
        );
    }

    /**
     * Render the shipping data and payment page.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Inertia\Response
     */
    public function shippingAndPaymentPage(
        Request $request
    ): \Inertia\Response | \Illuminate\Http\RedirectResponse {
        if (!$request->session()->has('cart')) {
            return redirect('/cart');
        }

        $customerData = PageHelperController::arrayToCamelCase(
            PageHelperController::customerData($request)->toArray()
        );

        return Inertia::render(
            'ShippingAndPayment',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'notLoggedIn' => !Auth::check(),
                'shippingMethods' => PageHelperController::shippingMethods(),
                'paymentMethods' => PageHelperController::paymentMethods(),
                'customerData' => $customerData,
                'orderMethods' => $request->session()->get('orderMethods', null)
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
    public function checkoutPage(
        Request $request
    ): \Inertia\Response | \Illuminate\Http\RedirectResponse {
        if (!$request->session()->has(['cart', 'customer', 'orderMethods'])) {
            return redirect('/cart');
        }

        $customerData = PageHelperController::arrayToCamelCase(
            PageHelperController::customerData($request)->toArray()
        );

        return Inertia::render(
            'Checkout',
            [
                'categories' => PageHelperController::categories(),
                'products' => PageHelperController::cartItems($request),
                'customerData' => $customerData,
                'orderMethods' => $request->session()->get('orderMethods'),
                'discountCode' => $request->session()->get('discountCode')
            ]
        );
    }

    public function orderedPage(): Response
    {
        return Inertia::render(
            'Ordered',
            [
                'categories' => PageHelperController::categories()
            ]
        );
    }

    public function salePage(int $saleId): Response
    {
        return Inertia::render(
            'Sale',
            [
                'categories' => PageHelperController::categories(),
                'sale' => PageHelperController::sale($saleId)
            ]
        );
    }

    public function loginPage(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            return redirect('user/dashboard');
        }

        return Inertia::render(
            'Login',
            [
                'categories' => PageHelperController::categories()
            ]
        );
    }

    public function registerPage(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        if (Auth::check()) {
            return redirect('user/dashboard');
        }

        return Inertia::render(
            'Register',
            [
                'categories' => PageHelperController::categories()
            ]
        );
    }

    public function dashboardPage(): Response
    {
        return Inertia::render(
            'Dashboard',
            [
                'categories' => PageHelperController::categories(),
                'orders' => Auth::user()->orders
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function add(\App\Http\Requests\AddToCartRequest $request): void
    {
        [
            'productId' => $productId,
            'count' => $count
        ] = $request->validated();
        if ($request->session()->has("cart.{$productId}")) {
            $request->session()->increment("cart.{$productId}", $count);
        } else {
            $request->session()->put("cart.{$productId}", $count);
        }
    }

    public function update(\App\Http\Requests\UpdateCartRequest $request): void
    {
        $valid = $request->validated();

        foreach($valid as [
            'id' => $productId,
            'quantity' => $quantity
        ]) {
            if ($quantity > 0) {
                $request->session()->put("cart.{$productId}", $quantity);
            } else {
                $request->session()->forget("cart.{$productId}");
            }
        }
    }

    public static function code(
        \App\Http\Requests\DiscountCodeRequest $request
    ): DiscountCode {
        $valid = $request->validated();

        if (
            Str::length($valid['code'] ?? '') === 0 &&
            $request->session()->has('discountCode')
        ) {
            return $request->session()->get('discountCode');
        }

        $discountCode = DiscountCode::where('code', $valid['code'] ?? -1)->firstOr(function() {
            $fake = new DiscountCode();
            $fake->discount = 0;
            return $fake;
        });
        $request->session()->put('discountCode', $discountCode);
        return $discountCode;
    }

    public static function saveShippingData(
        \App\Http\Requests\ShippingDataRequest $request
    ): \Illuminate\Http\RedirectResponse {
        if (!$request->session()->has('cart')) {
            return redirect()->action([PageController::class, 'cartPage']);
        }
        [
            'shippingData' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'emailAddress' => $emailAddress,
                'address' => $address
            ],
            'shippingMethod' => $shippingMethod,
            'paymentMethod' => $paymentMethod
        ] = $request->validated();
        $phoneNumber = $valid['phoneNumber'] ?? null;

        $transformedAddress = [];
        foreach ($address as $key => $item) {
            $transformedAddress[Str::snake($key)] = $item;
        }
        $transformedCustomer = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $emailAddress,
            'phone_number' => $phoneNumber
        ];

        $currentCustomer = PageHelperController::customerData($request);
        if (
            \Illuminate\Support\Facades\Auth::check() ||
            $request->session()->has('customer')
        ) {
            $currentAddress = $currentCustomer->address;
            $currentAddress->update($transformedAddress);
            $currentCustomer->update($transformedCustomer);
        } else {
            $currentCustomer = new \App\Models\Customer($transformedCustomer);
            $currentAddress = \App\Models\Address::create($transformedAddress);
            $currentCustomer->address()->associate($currentAddress)->save();
            $request->session()->put('customer', $currentCustomer);
        }

        $request->session()->put('orderMethods', [
            'shippingMethod' => \App\Models\ShippingMethod::with('shipper')->findOrFail($shippingMethod),
            'paymentMethod' => \App\Models\PaymentMethod::findOrFail($paymentMethod)
        ]);

        return redirect()->action([PageController::class, 'checkoutPage']);
    }

    public static function order(
        \Illuminate\Http\Request $request
    ): \Illuminate\Http\RedirectResponse {
        if (
            !$request->session()->has(['cart', 'orderMethods']) &&
            (
                !$request->session()->has('customer') ||
                !\Illuminate\Support\Facades\Auth::check()
            )
        ) {
            return redirect()->action([PageController::class, 'cartPage']);
        }

        $customer = $request->session()->get(
            'customer',
            \Illuminate\Support\Facades\Auth::user()->customer
        );
        $discountCode = $request->session()->get('discountCode', new \App\Models\DiscountCode());
        $products = PageHelperController::cartItems($request);
        $totalPrice = $products
            ->sum(fn ($product) =>  (float) ($product?->sales[0]?->pivot?->price ?? $product->price) * $product->quantity)
            * (1 - ($discountCode->discount / 100));
        [
            'shippingMethod' => $shippingMethod,
            'paymentMethod' => $paymentMethod
        ] = $request->session()->get('orderMethods');

        $order = new \App\Models\Order();
        $order->total = $totalPrice;
        $order->customer()->associate($customer);
        if ($discountCode->discount != 0) {
            $order->discountCode()->associate($discountCode);
        }
        $order->shippingMethod()->associate($shippingMethod);
        $order->paymentMethod()->associate($paymentMethod);
        $order->save();

        $productsToAttach = new \Illuminate\Support\Collection();
        $products->each(function ($product) use ($productsToAttach) {
            $productsToAttach->put(
                $product->id,
                ['quantity' => $product->quantity]
            );
        });

        info([$products, $productsToAttach]);

        $order->products()->sync($productsToAttach);
        $products->each(function ($product) {
            $product->number_in_stock -= $product->quantity;
            unset($product->quantity);
            $product->save();
        });

        $request->session()->forget([
            'discountCode',
            'cart',
            'orderMethods'
        ]);

        return redirect()->action([PageController::class, 'orderedPage']);
    }
}

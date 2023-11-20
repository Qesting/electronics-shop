<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function add(Request $request): void
    {
        [
            'productId' => $productId,
            'count' => $count
        ] = $request->validate([
            'productId' => [
                'required',
                'numeric',
                'exists:products,id',
            ],
            'count' => [
                'required',
                'numeric',
                'gt:0'
            ]
        ]);
        if ($request->session()->has("cart.{$productId}")) {
            $request->session()->increment("cart.{$productId}", $count);
        } else {
            $request->session()->put("cart.{$productId}", $count);
        }
    }

    public function update(Request $request): void
    {
        $valid = $request->validate([
            '*.id' => [
                'required',
                'numeric',
                'exists:products,id'
            ],
            '*.quantity' => [
                'required',
                'numeric',
                'gte:0'
            ]
        ]);

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

    public static function code(Request $request): ?int
    {
        $valid = $request->validate([
            'code' => [
                'nullable',
                'string',
                'max:10'
            ]
        ]);

        if (
            !isset($valid['code']) ||
            is_null($valid['code']) ||
            Str::length($valid['code']) === 0
        ) {
            return null;
        }

        return DiscountCode::where('code', $valid['code'])->firstOr(function() {
            $fake = new DiscountCode();
            $fake->discount = 0;
            return $fake;
        })->value('discount');
    }

    public static function saveShippingData(Request $request): \Illuminate\Support\Collection
    {
        $valid = $request->validate([
            'shippingData.firstName' => [
                'required',
                'string'
            ],
            'shippingData.lastName' => [
                'required',
                'string'
            ],
            'shippingData.emailAddress' => [
                'required',
                'email'
            ],
            'shippingData.phoneNumber' => [
                'nullable',
                'numeric'
            ],
            'shippingData.address.country' => [
                'required',
                'string'
            ],
            'shippingData.address.city' => [
                'required',
                'string'
            ],
            'shippingData.address.postalCode' => [
                'required',
                'regex:/^\d{2}-\d{3}$/'
            ],
            'shippingData.address.street' => [
                'required',
                'string'
            ],
            'shippingData.address.building' => [
                'required',
                'numeric'
            ],
            'shippingData.address.apartment' => [
                'nullable',
                'numeric'
            ],
            'shippingMethod' => [
                'required',
                'numeric',
                'exists:shipping_methods,id'
            ],
            'paymentMethod' => [
                'required',
                'numeric',
                'exists:payment_methods,id'
            ]
        ]);

        [
            'shippingData' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'emailAddress' => $emailAddress,
                'address' => $address
            ],
            'shippingMethod' => $shippingMethod,
            'paymentMethod' => $paymentMethod
        ] = $valid;
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

        return collect([
            'shippingMethod' => \App\Models\ShippingMethod::with('shipper')->findOrFail($shippingMethod),
            'paymentMethod' => \App\Models\PaymentMethod::findOrFail($paymentMethod)
        ]);
    }
}

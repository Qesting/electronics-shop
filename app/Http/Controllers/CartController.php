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

    public function code(Request $request): ?int
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
}

<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function register(
        \App\Http\Requests\RegisterRequest $request
    ): \Illuminate\Http\RedirectResponse {

        [
            'emailAddress' => $emailAddress,
            'password' => $password
        ] = $request->validated();

        if ($request->session()->has('customer')) {
            $customer = $request->session()->get('customer');
        } else {
            $address = new \App\Models\Address();
            $address->save();
            $customer = new \App\Models\Customer([
                'email_address' => $emailAddress
            ]);
            $customer->address()->associate($address)->save();
            unset($address);
            $customer->refresh();
        }

        $user = new \App\Models\User([
            'email_address' => $emailAddress,
            'password' => $password
        ]);
        $user->customer()->associate($customer)->save();

        return redirect('/user/login');
    }

    public function login(
        \App\Http\Requests\LoginRequest $request
    ): \Illuminate\Http\RedirectResponse {

        info($request->validated());

        [
            'emailAddress' => $emailAddress,
            'password' => $password
        ] = $request->validated();

        if (\Illuminate\Support\Facades\Auth::attempt([
            'email_address' => $emailAddress,
            'password' => $password
        ])) {
            $request->session()->regenerate();
            return redirect('/user/dashboard');
        }

        return back()->withErrors([
            'emailAddress' => 'Nie znaleziono użytkownika.'
        ])->onlyInput('emailAddress');
    }
}

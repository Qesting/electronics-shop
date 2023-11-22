<?php

namespace App\Http\Controllers;

use \Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Register a new user.
     *
     * @param \App\Http\Requests\RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(
        \App\Http\Requests\RegisterRequest $request
    ): RedirectResponse {

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

    /**
     * Log a user in.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(
        \App\Http\Requests\LoginRequest $request
    ): RedirectResponse {

        [
            'emailAddress' => $emailAddress,
            'password' => $password,
            'remember' => $remember
        ] = $request->validated();

        if (Auth::attempt([
            'email_address' => $emailAddress,
            'password' => $password,
        ], $remember)) {
            $request->session()->regenerate();
            return redirect('/user/dashboard');
        }

        return back()->withErrors([
            'emailAddress' => 'Nie znaleziono użytkownika.'
        ])->onlyInput('emailAddress');
    }

    /**
     * Save user's shipping data.
     *
     * @param \App\Http\Requests\UserShippingDataRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveShippingData(
        \App\Http\Requests\UserShippingDataRequest $request
    ): RedirectResponse {
        [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'emailAddress' => $emailAddress,
            'address' => $address
        ] = $request->validated();
        $phoneNumber = $valid['phoneNumber'] ?? null;

        $transformedAddress = [];
        foreach ($address as $key => $item) {
            $transformedAddress[\Illuminate\Support\Str::snake($key)] = $item;
        }
        $transformedCustomer = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $emailAddress,
            'phone_number' => $phoneNumber
        ];

        $currentCustomer = Auth::user()->customer;
        $currentCustomer->address()->update($transformedAddress);
        $currentCustomer->update($transformedCustomer);

        return back();
    }

    /**
     * Change user's password.
     *
     * @param \App\Http\Requests\NewPasswdRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswd(
        \App\Http\Requests\NewPasswdRequest $request
    ): RedirectResponse {
        [
            'newPassword' => $newPassword
        ] = $request->validated();

        Auth::user()->password = $newPassword;
        Auth::user()->save();

        Auth::logoutOtherDevices($newPassword);

        return redirect('user/dashboard');
    }

    /**
     * Add a product review.
     *
     * @param \App\Http\Requests\AddReviewRequest $request
     * @param int $productId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addReview(
        \App\Http\Requests\AddReviewRequest $request,
        int $productId
    ): RedirectResponse {
        $valid = $request->validated();

        $review = new \App\Models\ProductReview($valid);
        $review->user()->associate(Auth::id());
        $review->product()->associate($productId)->save();

        return back();
    }

    /**
     * Register a user out.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect('/');
    }
}

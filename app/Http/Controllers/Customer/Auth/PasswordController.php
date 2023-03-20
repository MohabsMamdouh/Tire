<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Customer\PasswordUpdateRequest;


use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Customer;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(PasswordUpdateRequest $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validated();

        $customer->fill($request->all());
        $customer->save();

        return back()->with('status', 'password-updated');
    }
}
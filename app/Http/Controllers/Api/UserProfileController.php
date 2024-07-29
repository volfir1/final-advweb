<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Customer;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $customer = $user->customer;

        return response()->json([
            'user' => $user,
            'customer' => $customer
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->customer;
    
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $user->update([
            'name' => $request->name ?: $user->name,
            'email' => $request->email ?: $user->email,
        ]);
    
        $customer->update([
            'fname' => $request->fname ?: $customer->fname,
            'lname' => $request->lname ?: $customer->lname,
            'contact' => $request->contact ?: $customer->contact,
            'address' => $request->address ?: $customer->address,
        ]);
    
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    

}
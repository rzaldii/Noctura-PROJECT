<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class ProfileCustomerController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $customer = Customer::findOrFail($userId);

        return view('customer.profile', compact('customer'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('landing')->with('success', 'Berhasil logout.');
    }
}

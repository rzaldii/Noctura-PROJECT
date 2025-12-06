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

    public function edit()
    {
        $userId = session('user_id');
        $customer = Customer::findOrFail($userId);

        return view('customer.profile_edit', compact('customer'));
    }

    public function update(Request $request)
    {
        $userId = session('user_id');
        $customer = Customer::findOrFail($userId);

        // VALIDASI INPUT
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPDATE FIELD BIASA
        $customer->full_name = $request->full_name;
        $customer->username  = $request->username;

        // UPDATE FOTO (jika ada file diupload)
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/customers'), $filename);

            // simpan ke database
            $customer->image_path = 'uploads/customers/' . $filename;
        }

        $customer->save();

        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui!');
    }

}

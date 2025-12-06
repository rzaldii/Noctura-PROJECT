<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:customer,organizer'
        ]);

        if ($request->role === 'customer') {
            $user = DB::table('customers')->where('email', $request->email)->first();
        } else {
            $user = DB::table('organizers')->where('email', $request->email)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password atau role salah.');
        }

        // Simpan session
        session([
            'logged_in' => true,
            'role' => $request->role,
            'user_id' => $user->id,
            'email' => $user->email,
            'browser_fingerprint' => $request->header('User-Agent'),
        ]);

        if ($request->role === 'organizer') {
            session([
                'user' => [
                    'fullname' => $user->organization_name ?? $user->username,
                    'image' => $user->image_path ?? 'images/default-avatar.png',
                    'email' => $user->email,
                ]
            ]);
        }

        return redirect()->route($request->role . '.dashboard');
    }


    public function registerPage()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'role'      => 'required|in:customer,organizer',
            'fullname'  => 'required|string|max:150',
            'username'  => 'required|string|max:80',
            'email'     => 'required|email|max:150',
            'password'  => 'required|min:3',
            'image'     => 'nullable|image|max:2048',
            'description' => 'nullable|string'
        ]);

        // Upload file jika ada
        $path = null;
        if ($request->hasFile('image')) {
            $stored = $request->file('image')->store('uploads', 'public');
            $path = 'storage/' . $stored;
        }

        if ($request->role === 'customer') {

            // Email unik hanya di tabel customers
            if (DB::table('customers')->where('email', $request->email)->exists()) {
                return back()->with('error', 'Email sudah digunakan oleh customer lain.')->withInput();
            }

            // Username unik hanya di tabel customers
            if (DB::table('customers')->where('username', $request->username)->exists()) {
                return back()->with('error', 'Username sudah digunakan oleh customer lain.')->withInput();
            }

            DB::table('customers')->insert([
                'full_name'   => $request->fullname,
                'username'    => $request->username,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'image_path'  => $path,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

        } else {

            // Email unik hanya dalam tabel organizers
            if (DB::table('organizers')->where('email', $request->email)->exists()) {
                return back()->with('error', 'Email sudah digunakan oleh organizer lain.')->withInput();
            }

            // Username unik hanya dalam tabel organizers
            if (DB::table('organizers')->where('username', $request->username)->exists()) {
                return back()->with('error', 'Username sudah digunakan oleh organizer lain.')->withInput();
            }

            DB::table('organizers')->insert([
                'organization_name' => $request->fullname,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'image_path'        => $path,
                'description'       => $request->description,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        return redirect()->route('login')->with('register_success', true);

    }

}


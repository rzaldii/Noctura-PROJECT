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
            return back()->with('error', 'Email atau password salah.');
        }

        // Simpan session
        session([
            'logged_in' => true,
            'role' => $request->role,
            'user_id' => $user->id,
            'email' => $user->email,
            'browser_fingerprint' => $request->header('User-Agent'),
        ]);

        return redirect()->route($request->role . '.dashboard');
    }


    public function registerPage()
    {
        return view('auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'role' => 'required|in:customer,organizer',
            'fullname' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'image' => 'nullable|image',
            'description' => 'nullable'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }

        if ($request->role === 'customer') {

            DB::table('customers')->insert([
                'full_name' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image_url' => $path,
            ]);

        } else {

            DB::table('organizers')->insert([
                'name' => $request->fullname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image_url' => $path,
                'description' => $request->description
            ]);
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

}


<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('register');
    }

    // Menangani proses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,librarian',
        ]);

        $user = Pengguna::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Jika permintaan adalah API
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registration successful.',
                'data' => $user
            ], 201);
        }

        // Jika permintaan dari browser (form)
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = Pengguna::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.'
                ], 401);
            }

            return redirect()->back()->withErrors('Invalid credentials.');
        }

        // Jika permintaan adalah API
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'data' => $user
            ], 200);
        }

        // Jika login berhasil dari browser, arahkan ke dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin');
        } elseif ($user->role === 'librarian') {
            return redirect()->route('librarian');
        }

        return redirect()->back()->withErrors('Invalid credentials.');
    }

    // Logout pengguna
    public function logout(Request $request)
    {
        auth()->logout();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout successful.'
            ], 200);
        }

        return redirect('/login');
    }
}
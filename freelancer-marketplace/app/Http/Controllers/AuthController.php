<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:freelancer,client',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, // Encryption handled in the model
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email, // Decryption handled in the model
                'role' => $user->role,
            ]
        ], 201);
    }


    // User Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Retrieve all users and decrypt emails for comparison (not recommended for large databases)
        $users = User::all()->filter(function ($user) use ($credentials) {
            return $user->email === $credentials['email']; // Email is automatically decrypted in the model
        });

        $user = $users->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }


    // Get Authenticated User
    public function userProfile(Request $request)
    {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => Crypt::decryptString($request->user()->email), // Decrypting email
                'role' => $request->user()->role
            ]
        ]);
    }

    // Logout User
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard', ['user' => Auth::user()]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to access the dashboard.');
    }
}

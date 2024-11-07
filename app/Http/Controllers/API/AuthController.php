<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Constants\Status;
use App\Http\Controllers\Constants\StatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if (auth()->check()) {

            if (auth()->user()->role === 'admin') {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'password' => 'required',
                    'role' => 'required|in:employee,hr,admin',
                ]);
            }
            elseif (auth()->user()->role === 'hr') {
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'password' => 'required',
                    'role' => 'required|in:employee',
                ]);
            }

            else {
                return response()->json(['message' => 'Unauthorized'], Status::UNAUTHORIZED);
            }
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'User created successfully!'], Status::SUCCESS);
    }

    public function hrSelfRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => 'required',
            'role' => 'required|in:hr',
        ]);

        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            return response()->json(['message' => 'HR user already exists'], Status::INVALID_REQUEST);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'hr',
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'HR registered successfully!'], Status::SUCCESS);
    }
    public function approveUser(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'hr') {
            return response()->json(['message' => 'Unauthorized'], Status::UNAUTHORIZED);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Status::NOT_FOUND);
        }

        $user->status = 'approved';
        $user->save();

        return response()->json(['message' => 'User approved successfully!'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->status !== 'approved') {
            return response()->json(['message' => 'Invalid credentials or account not approved'], Status::UNAUTHORIZED);
        }

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], Status::UNAUTHORIZED);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], Status::SUCCESS);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully!'], Status::SUCCESS);
    }
}

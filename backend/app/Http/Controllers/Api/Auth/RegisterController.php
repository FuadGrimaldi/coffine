<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseCostum;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'address' => 'nullable|string',
                'phone' => 'nullable|string',
                'role' => 'nullable|string',
            ]);

            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            // Generate a Sanctum token for the user
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            // Return the user's data along with the token
            return ResponseCostum::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User registered successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseCostum::error(
                null,
                'Registration failed: ' . $e->getMessage(),
                500
            );
        }
    }
}

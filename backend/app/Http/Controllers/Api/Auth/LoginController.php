<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Helpers\ResponseCostum;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Handle the incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the request
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            // Attempt to find the user
            $user = User::where('email', $request->email)->first();

            // Check if the user exists and the password is correct
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            // Create a new Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            // Return the token in the response
            return ResponseCostum::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User logged in successfully');
        } catch (\Exception $e) {
            // Log the error
            Log::channel('daily')->error('Login error: ' . $e->getMessage(), [
                'email' => $request->email,
                'exception' => $e,
            ]);
            DB::rollBack();
            // Return error response
            return ResponseCostum::error(
                null,
                'Server Error',
                500
            );
        }
    }
}

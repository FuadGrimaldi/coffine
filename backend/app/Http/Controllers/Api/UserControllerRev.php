<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseCostum;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserCreateReq;
use App\Http\Requests\UserUpdateReq;
use App\Models\User;

class UserControllerRev extends Controller
{
    public function getProfile(Request $request)
    {
        try {
            // Get the authenticated user
            $user = $request->user();
            
            if (!$user) {
                return ResponseCostum::error(null, 'User not found', 404);
            }

            // Return the user's profile data
            return ResponseCostum::success(new UserResource($user), 'User profile retrieved successfully', 200);

        } catch (\Exception $e) {
            // Log the error
            Log::channel('daily')->error('Error in getProfile: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $request->user() ? $request->user()->id : null,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Check if the logged-in user has admin role
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            return ResponseCostum::success(UserResource::collection(User::all()), 'All users retrieved successfully', 200);
        } catch (\Exception $e) {
            Log::channel('daily')->error('Error in index: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateReq $request)
    {
        try {
            // Check if the logged-in user has admin role
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $user = User::create($request->all());

            // Return the form for creating a new user
            return ResponseCostum::success(new UserResource($user), 'User created successfully', 201);   
        } catch (\Exception $e) {
            Log::channel('daily')->error('Error in create: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Check if the logged-in user has admin role
            $user = User::findorFail($id);
            if (!$user) {
                return ResponseCostum::error(null, 'User not found', 404);
            }
            return ResponseCostum::success(new UserResource($user), 'User retrieved successfully', 200);
        } catch (\Exception $e) {
            Log::channel('daily')->error('Error in show: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateReq $request, string $id)
    {
        try {
            $data = $request->validated();
            // Check if the logged-in user has admin role
            $user = User::find($id);
            if (!$user) {
                return ResponseCostum::error(null, 'User not found', 404);
            }
            $user->update($data);
            return ResponseCostum::success(new UserResource($user), 'User updated successfully', 200);
        } catch (\Exception $e) {
            Log::channel('daily')->error('Error in update: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Check if the logged-in user has admin role
            $user = User::find($id);
            if (!$user) {
                return ResponseCostum::error(null, 'User not found', 404);
            }
            $user->delete();
            return ResponseCostum::success(null, 'User deleted successfully', 204);
        } catch (\Exception $e) {
            Log::channel('daily')->error('Error in destroy: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

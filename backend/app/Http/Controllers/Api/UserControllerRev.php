<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseCostum;
use Illuminate\Support\Facades\Log;

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
            return ResponseCostum::success($user, 'User profile retrieved successfully');

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
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

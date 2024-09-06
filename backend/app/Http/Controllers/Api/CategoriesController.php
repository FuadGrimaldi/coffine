<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\ResponseCostum;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $categories = Category::all();
            return ResponseCostum::success(CategoryResource::collection($categories), 'Categories retrieved successfully', 200);
        } catch (\Exception $e) {
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
    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $category = Category::create($request->all());
            return ResponseCostum::success(new CategoryResource($category), 'Category created successfully', 201);
        } catch (\Exception $e) {
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $category = Category::find($id);
            if (!$category) {
                return ResponseCostum::error(null, 'Category not found', 404);
            }
            return ResponseCostum::success(new CategoryResource($category), 'Category retrieved successfully', 200);
        } catch (\Exception $e) {
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
    public function update(Request $request, string $id)
    {
        try {
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $category = Category::find($id);
            if (!$category) {
                return ResponseCostum::error(null, 'Category not found', 404);
            }
            $category->update($request->all());
            return ResponseCostum::success(new CategoryResource($category), 'Category updated successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = auth()->user();
            if (!$user || $user->role !== 'admin') {
                return ResponseCostum::error(null, 'Unauthorized. Admin access required.', 403);
            }
            $category = Category::find($id);
            if (!$category) {
                return ResponseCostum::error(null, 'Category not found', 404);
            }
            $category->delete();
            return ResponseCostum::success(null, 'Category deleted successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

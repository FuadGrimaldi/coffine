<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Helpers\ResponseCostum;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            return ResponseCostum::success(ProductResource::collection($products), 'Products retrieved successfully', 200);
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
    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->all());
            return ResponseCostum::success(new ProductResource($product), 'Product created successfully', 201);
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
            $product = Product::find($id);
            if (!$product) {
                return ResponseCostum::error(null, 'Product not found', 404);
            }
            return ResponseCostum::success(new ProductResource($product), 'Product retrieved successfully', 200);
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
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return ResponseCostum::error(null, 'Product not found', 404);
            }
            $product->update($request->all());
            return ResponseCostum::success(new ProductResource($product), 'Product updated successfully', 200);
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
            $product = Product::find($id);
            if (!$product) {
                return ResponseCostum::error(null, 'Product not found', 404);
            }
            $product->delete();
            return ResponseCostum::success(null, 'Product deleted successfully', 204);
        } catch (\Exception $e) {
            return ResponseCostum::error(null, 'An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

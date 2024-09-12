<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\Product;
use App\Http\Resources\ProductDetailResource;
use App\Http\Requests\ProductDetailRequest;
use App\Http\Requests\ProductDetailUpdateReq;
use App\Helpers\ResponseCostum;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $product = ProductDetail::all();
            return ResponseCostum::success(ProductDetailResource::collection($product), 'Product retrieved successfully', 200);
        } catch (\Throwable $th) {
            return ResponseCostum::error($th->getMessage(), 'Product retrieved failed', 500);
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
    public function store(ProductDetailRequest $request)
    {
        try {
            $product = Product::create($request->validated());

            // Pastikan ada file profile_image dalam request
            if ($request->hasFile('categories_image')) {
                // Upload gambar ke Cloudinary
                $uploadedFileUrl = Cloudinary::upload($request->file('categories_image')->getRealPath())->getSecurePath();
            } else {
                // Jika file tidak diupload, set default atau return error
                return ResponseCostum::error('Profile image is required', 'Product creation failed', 400);
            }

            $productDetail = ProductDetail::create([
                'product_id' => $product->id,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'image' => $uploadedFileUrl,
            ]);
            return ResponseCostum::success(ProductDetailResource::make($productDetail), 'Product created successfully', 201);
        } catch (\Throwable $th) {
            return ResponseCostum::error($th->getMessage(), 'Product created failed', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = ProductDetail::find($id);
            return ResponseCostum::success(ProductDetailResource::make($product), 'Product retrieved successfully', 200);
        } catch (\Throwable $th) {
            return ResponseCostum::error($th->getMessage(), 'Product retrieved failed', 500);
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
    public function update(ProductDetailUpdateReq $request, string $id)
    {
        try {
            // dd($request->validated());
            $productDetail = ProductDetail::find($id);
            if (!$productDetail) {
                return ResponseCostum::error('Product not found', 'Product update failed', 404);
            }
            
            if ($productDetail->product) {
                $productDetail->product->update($request->validated());
            }
            
            $updateData = [
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
            ];
            
            // Check if there's a new image
            if ($request->hasFile('image')) {
                // Delete the old image from Cloudinary if it exists
                if ($productDetail->image) {
                    // Extract public ID from the old image URL
                    $oldImagePublicId = basename(parse_url($productDetail->image, PHP_URL_PATH), '.' . pathinfo($productDetail->image, PATHINFO_EXTENSION));
                    Cloudinary::destroy($oldImagePublicId);
                }
                
                // Upload the new image to Cloudinary
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
                $updateData['image'] = $uploadedFileUrl;
            }
            
            $productDetail->update($updateData);
            
            return ResponseCostum::success(ProductDetailResource::make($productDetail), 'Product updated successfully', 200);
        } catch (\Throwable $th) {
            return ResponseCostum::error($th->getMessage(), 'Product update failed', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $productDetail = ProductDetail::find($id);
            if (!$productDetail) {
                return ResponseCostum::error('Product not found', 'Product delete failed', 404);
            }
            
            // Delete associated product if it exists
            if ($productDetail->product) {
                $productDetail->product->delete();
            }
            
            $productDetail->delete();
            return ResponseCostum::success(null, 'Product and associated data deleted successfully', 204);
        } catch (\Throwable $th) {
            return ResponseCostum::error($th->getMessage(), 'Product delete failed', 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Order;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Helpers\ResponseCostum;

class CartController extends Controller
{
    /**
     * Add a product to the user's cart.
     */
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:product_details,id',
                'qty' => 'required|integer|min:1'
            ]);

            $user = $request->user();
            $productDetail = ProductDetail::where('product_id', $request->product_id)->firstOrFail();

            // Check if the product already exists in the user's cart
            $existingCart = Cart::where('user_id', $user->id)
                                ->where('product_id', $request->product_id)
                                ->first();

            if ($existingCart) {
                // If the product exists, update the quantity and total amount
                $existingCart->qty += $request->qty;
                $existingCart->total_amount = $productDetail->price * $existingCart->qty;
                $existingCart->save();
                $cart = $existingCart;
            } else {
                // If the product doesn't exist, create a new cart item
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    'total_amount' => $productDetail->price * $request->qty
                ]);
            }

            // TODO: Implement gift logic here
            // For example:
            // if ($cart->qty >= 5) {
            //     $cart->gift = 'Free gift for buying 5 or more!';
            //     $cart->save();
            // }

            return ResponseCostum::success(new CartResource($cart), 'Product added to cart successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to add product to cart', 500);
        }
    }

    /**
     * Get the user's cart.
     */
    public function getCart(Request $request)
    {
        try {   
            $user = $request->user();
            $cart = Cart::where('user_id', $user->id)->with('productDetail.product')->get();

            return ResponseCostum::success(CartResource::collection($cart), 'Cart fetched successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to get cart', 500);
        }
    }

    public function removeFromCart(Request $request, $id)
    { 
        try {
            $user = $request->user();
            $cart = Cart::where('user_id', $user->id)->findOrFail($id);
            $cart->delete();

            return ResponseCostum::success(null, 'Product removed from cart successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to remove product from cart', 500);
        }
    }

    public function index()
    {
        try {
            $carts = Cart::all();
            return ResponseCostum::success(CartResource::collection($carts), 'Cart fetched successfully', 204);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to get cart', 500);
        }
    }
}

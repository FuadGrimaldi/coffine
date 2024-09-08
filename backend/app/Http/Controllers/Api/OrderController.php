<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use App\Helpers\ResponseCostum;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getOrderByUser(Request $request)
    {
        try {   
            $user = $request->user();
            $orders = Order::where('user_id', $user->id)->with(['user', 'orderItems.productDetail.product'])->get();
            return ResponseCostum::success(OrderResource::collection($orders), 'Orders fetched successfully', 200);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to get orders: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Create an order from the user's cart.
     */
    public function createOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = $request->user();
            $cart = Cart::where('user_id', $user->id)->with('productDetail.product')->get();
    
            if ($cart->isEmpty()) {
                return ResponseCostum::error('Cart is empty', 400);
            }

            $totalAmount = 0;
            $totalQty = 0;

            foreach ($cart as $item) {
                if (!$item->productDetail || $item->productDetail->price === null) {
                    DB::rollBack();
                    return ResponseCostum::error('Product price is null for product_id: ' . $item->product_id, 400);
                }
                $totalAmount += $item->productDetail->price * $item->qty;
                $totalQty += $item->qty;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'qty' => $totalQty,
                'total_amount' => $totalAmount,
                'order_date' => now(),
                'status' => 'pending'
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->productDetail->product_id,
                    'quantity' => $item->qty,
                    'price' => $item->productDetail->price * $item->qty,
                ]);
            }
        
            Cart::where('user_id', $user->id)->delete();

            $order->load('orderItems.productDetail.product');
            DB::commit();
            return ResponseCostum::success(new OrderResource($order), 'Order created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseCostum::error('Failed to create order: ' . $e->getMessage(), 400);
        }
    }

    public function index()
    {
        $orders = Order::with('orderItems.productDetail.product')->get();
        return ResponseCostum::success(OrderResource::collection($orders), 'Orders fetched successfully', 200);
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
        $order = Order::with('orderItems.productDetail.product')->findOrFail($id);
        return ResponseCostum::success(new OrderResource($order), 'Order fetched successfully', 200);
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
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return ResponseCostum::success(null, 'Order deleted successfully', 204);
        } catch (\Exception $e) {
            return ResponseCostum::error('Failed to delete order: ' . $e->getMessage(), 400);
        }
    }
}

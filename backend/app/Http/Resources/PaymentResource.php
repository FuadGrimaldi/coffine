<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'transaction_code' => $this->transaction_code,
        'payment_method' => $this->payment_method,
        'payment_date' => $this->payment_date,
        'status_payment' => $this->status,
        'order' => $this->order ? [
            'id' => $this->order->id,
            'user' => $this->order->user ? [
                'id' => $this->order->user->id,
                'name' => $this->order->user->name,
                'email' => $this->order->user->email,
            ] : null,
            'qty' => $this->order->qty,
            'order_items' => $this->order->orderItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_detail' => $item->productDetail ? [
                            'id' => $item->productDetail->id,
                            'product' => $item->productDetail->product ? [
                                'id' => $item->productDetail->product->id,
                                'name' => $item->productDetail->product->name,
                            ] : 'Product not found',
                            'price' => $item->productDetail->price,
                        ] : 'ProductDetail not found',
                    'quantity' => $item->quantity,
                    'amount' => $item->price,
                ];
            }),
            'status' => $this->order->status,
            'total_amount' => $this->amount,
        ] : null,
    ];
}
}
        
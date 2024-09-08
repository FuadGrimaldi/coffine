<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user' => $this->user ? [
                'name' => $this->user->name,
                'address' => $this->user->address,
                'phone' => $this->user->phone,
            ] : null,
            'product' => $this->productDetail ? [
                'name' => $this->productDetail->product->name,
                'stock' => $this->productDetail->product->stock,
            ]: null,
            'qty' => $this->qty,
            'total_amount' => $this->total_amount,
        ];
    }
    
}

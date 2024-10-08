<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'total_amount',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class, 'product_id', 'id');
    }
}

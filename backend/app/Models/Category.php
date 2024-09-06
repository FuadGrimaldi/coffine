<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = ['name'];

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'category_id');
    }
}

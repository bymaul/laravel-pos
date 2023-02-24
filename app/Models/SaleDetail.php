<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}

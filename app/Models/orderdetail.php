<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderdetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail_master';
    public function product_detail()
    {
        return $this->hasOne(product::class, 'product_id', 'product_id');
    }
    public function product_type_detail()
    {
        return $this->hasOne(producttype::class, 'product_type_id', 'product_type_id');
    }
}

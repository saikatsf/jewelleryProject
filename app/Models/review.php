<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;
    protected $table = 'review_master';
    
    public function coverimage()
    {
        return $this->hasOne(reviewimage::class, 'review_id', 'review_id')->latest();
    }
    public function product_detail()
    {
        return $this->hasOne(product::class, 'product_id', 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\product;

class product extends Model
{
    use HasFactory;
    protected $table = 'product_master';

    public function category()
    {
        return $this->hasOne(category::class, 'category_id', 'category_id');
    }
    public function image()
    {
        return $this->hasMany(productimg::class, 'product_id', 'product_id');
    }
    public function coverimage()
    {
        return $this->hasOne(productimg::class, 'product_id', 'product_id')->oldest();
    }
    public function types()
    {
        return $this->hasMany(producttype::class, 'product_id', 'product_id');
    }
    public function collections()
    {
        return $this->hasMany(productcol::class, 'product_id', 'product_id');
    }
}

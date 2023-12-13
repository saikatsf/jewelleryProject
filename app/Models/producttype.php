<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producttype extends Model
{
    use HasFactory;
    protected $table = 'product_type_master';
    
    public function getcolor()
    {
        return $this->belongsTo(color::class, 'product_color', 'color_id');
    }
    public function getpolish()
    {
        return $this->belongsTo(polish::class, 'product_polish', 'polish_id');
    }
    public function getsize()
    {
        return $this->belongsTo(size::class, 'product_size', 'size_id');
    }
}

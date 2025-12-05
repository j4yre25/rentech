<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category_id', 'stock_quantity', 'color', 'description', 'images'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')->withTimestamps();
    }

    // Add category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
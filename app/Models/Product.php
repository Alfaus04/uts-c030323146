<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'product_code',
        'category_id', 
        'price', 'stock', 
        'description', 
        'material', 
        'weight'
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transaction()
    {
    return $this->belongsTo(Transaction::class);
    }

}

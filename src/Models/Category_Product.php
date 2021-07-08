<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Product extends Model
{
    use HasFactory;

    protected $table = "category_product";

    protected $fillable = [
        'product_id', 'category_id', 'status',
    ];
}

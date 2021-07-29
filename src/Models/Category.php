<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    const LIMIT = 10;
    const ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'status',
        'shop_id',
    ];

    public function products() {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public static function getCategoryInstance($id) {
        return Category::find($id);
    }

    public function addCategory($request) {
        $this->name = $request->name;
        $this->shop_id = $request->shop_id;
        $this->status = Category::ACTIVE;
        $this->save();
    }

    public static function editCategoryDetails($request) {
        $category = Category::getCategoryInstance($request->category_id);
        if($category != null) {
            $category->name = $request->name;
            $category->update();
            return $category;
        }
    }

    public static function categoryRestore($id) {
        return Category::withTrashed()->where('id', $id)->restore();
    }

    public static function getAllCategories($limit = Category::LIMIT) {
        return Category::paginate($limit);
    }
}

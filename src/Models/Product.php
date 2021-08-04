<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const LIMIT = 11;
    const ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'owner_id',
        'vendor_id',
        'category_id',
        'description',
        'measurement_unit_id',
        'warehouse_id',
        'status'
    ];

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function stocks() {
        return $this->hasMany(Stock::class);
    }

    public function rates() {
        return $this->hasMany(Rate::class);
    }

    public function measurement_units() {
        return $this->hasMany(Measurement_Unit::class, 'measurement_unit_id');
    }

    public function addProduct($request) {
        $this->code = $request->code;
        $this->owner_id = $request->owner_id;
        $this->description = $request->description;
        $this->measurement_unit_id = $request->measurement_unit_id;
        $this->status = Product::ACTIVE;
        if($request->has('vendor_id') && $request->vendor_name == null) {
            $this->vendor_id = $request->vendor_id;
        } else if($request->has('vendor_name') && $request->vendor_id == null) {
            $vendor = new Vendor;
            $vendor->addVendor($request);
            $this->vendor_id = $vendor->id;
        }
        if($this->save()) {
            $id = $this->id;
            $this->categories()->attach($request->category_ids, ['status' => Product::ACTIVE]);
            $product_rates = new Rate;
            return response([
                'code' => 201,
                'status' => true,
                'message' => 'Product Created Successfully',
                'data' => ['product' => $this, 'product_rates' => $product_rates->associateProductRates($request, $id)],
            ]);
        } else {
            return response([
                'code' => 200,
                'status' => false,
                'message' => 'Product Not Created',
            ]);
        }
    }

    public static function updateProductDetails($request) {
        $product = Product::getProductInstance($request->product_id);
        $product->code = $request->code;
        $product->owner_id = $request->owner_id;
        $product->vendor_id = $request->vendor_id;
        $product->description = $request->description;
        $product->measurement_unit_id = $request->measurement_unit_id;
        $product->status = Product::ACTIVE;
        if($product->update()) {
            if ($product->categories->pluck('id')->toArray() != $request->category_ids) {
                $product->categories()->detach();
                $product->categories()->attach($request->category_ids, ['status' => Product::ACTIVE]);
            }
            return $product;
        } else {
            return [];
        }
    }

    public static function getProductInstance($id) {
        return Product::find($id);
    }

    public static function productRestore($id) {
        return Product::withTrashed()->where('id', $id)->restore();
    }

    public static function getAllProducts($limit = Product::LIMIT) {
        return Product::with('rates', 'stocks', 'categories', 'vendor', 'stocks.warehouse')->paginate($limit);
    }

    public static function getProductDetails($id) {
        return $products = Product::where('id', $id)->with('rates', 'categories', 'vendor', 'stocks.warehouse')->get();
    }

    public static function getCompareProductDetails($product_id_1, $product_id_2) {
        return Product::whereIn('id', [$product_id_1, $product_id_2])->with('rates', 'categories', 'vendor', 'stocks.warehouse')->get();
    }

    public static function compareTwoProducts($request) {
        if(Product::where('id', $request->product_id_1)->exists() && Product::where('id', $request->product_id_2)->exists()) {
            $products = Product::getCompareProductDetails($request->product_id_1, $request->product_id_2);
            return response([
                'code' => 201,
                'status' => true,
                'message' => 'Success',
                'data' => ['product_1' => $products[0],'product_2' => $products[1]],
            ]);
        } else {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Product does\'t exists!',
            ]);
        }
    }

        public static function advancedProductSearchForAdmin ($request) {
            $products = Product::query();
            if($request->all() != null) {
                if($request->code != null) {
                    $products->where('code','like', '%'.$request->code.'%');
                }
                if($request->category_id != null) {
                    $products->whereHas('categories', function($q) use ($request){
                        $q->where('category_id', $request->category_id);
                    });
                }
                if($request->purchase_rate != null) {
                    $products->whereHas('rates', function($q) use ($request){
                        $q->where('purchase_rate', $request->purchase_rate);
                    });
                }
                if($request->sale_rate != null) {
                    $products->whereHas('rates', function($q) use ($request){
                        $q->where('sale_rate', $request->sale_rate);
                    });
                }
                if($request->min_stock_level != null) {
                    $products->whereHas('stocks', function($q) use ($request){
                        $q->where('min_stock_level', $request->min_stock_level);
                    });
                }
                if($request->max_stock_level != null) {
                    $products->whereHas('stocks', function($q) use ($request){
                        $q->where('max_stock_level', $request->max_stock_level);
                    });
                }
                if($request->quantity != null) {
                    $products->whereHas('stocks', function($q) use ($request){
                        $q->where('quantity','like', '%'.$request->quantity.'%');
                    });
                }
                if($request->vendor_id != null) {
                    $products->whereHas('vendor', function($q) use ($request){
                        $q->where('vendor_id', $request->vendor_id);
                    });
                }
                return $products->get();
            } else {
                return null;
            }
            
        }
}

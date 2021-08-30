<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE = 1;

    protected $table = "product_rates";

    protected $fillable = [
        'purchase_rate',
        'sale_rate',
        'dealer_sale_price',
        'wholesale_sale_price' ,
        'retailer_sale_price',
        'status'
    ];

    public function product() {
        return $this->hasOne(Product::class);
    }

    public static function updateProductRates($request) {
        $product_rates = Rate::getRateInstance($request->rate_id);
        $product_rates->purchase_rate = $request->purchase_rate;
        $product_rates->sale_rate = $request->sale_rate;
        $product_rates->dealer_sale_price = $request->dealer_sale_price;
        $product_rates->wholesale_sale_price = $request->wholesale_sale_price;
        $product_rates->retailer_sale_price = $request->retailer_sale_price;
        $product_rates->status = Rate::ACTIVE;
        if($product_rates->update()) {
            return $product_rates;
        } else {
            return [];
        }
    }

    public function associateProductRates($request, $id) {
        $product = Product::getProductInstance($id);
        $product_rates = new Rate(['purchase_rate' => $request->purchase_rate, 'sale_rate' => $request->sale_rate, 'dealer_sale_price' => $request->dealer_sale_price, 'wholesale_sale_price' => $request->wholesale_sale_price, 'retailer_sale_price' => $request->retailer_sale_price, 'branch_id' => $request->branch_id, 'status' => Rate::ACTIVE]);
        if($product->rates()->save($product_rates)) {
            return  $product_rates;
        } else {
            return [];
        }
    }

    public static function getRateInstance($id) {
        return Rate::find($id);
    }
}

<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE = 1;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'name',
        'quantity',
        'preferred_vendor',
        'min_stock_level',
        'max_stock_level',
        'reorder_quantity',
        'rack_no',
        'opening_stock',
        'status'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function warehouse() {
        return $this->belongsTo(WareHouse::class);
    }

    public function addStock($request) {
        $warehouse = WareHouse::where('branch_id', $request->branch_id)->first();
        if($warehouse == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Branch Store does\'t exists!',
            ]);
        } else {
            $this->product_id = $request->product_id;
            $this->warehouse_id = $warehouse->id;
            $this->name = $request->name;
            $this->quantity = $request->quantity;
            $this->preferred_vendor = $request->preferred_vendor ?? 0;
            $this->min_stock_level = $request->min_stock_level ?? 0;
            $this->max_stock_level = $request->max_stock_level ?? 0;
            $this->reorder_quantity = $request->reorder_quantity ?? 0;
            $this->rack_no = $request->rack_no;
            $this->opening_stock = $request->opening_stock ?? 0;
            $this->status = Stock::ACTIVE;
            if($this->save()) {
                $this->warehouse;
                return response([
                    'code' => 201,
                    'status' => true,
                    'message' => 'Stock Save Successfully',
                    'data' =>  ['stock' => $this],
                ]);
            } else {
                return response([
                    'code' => 200,
                    'status' => false,
                    'message' => 'Stock Not Save Successfully',
                ]);
            }
        }
    }

    public static function updateProductStocks($request) {
        $stock = Stock::getStockDetails($request->stock_id);
        $stock->name = $request->name;
        $stock->quantity = $request->quantity;
        $stock->preferred_vendor = $request->preferred_vendor ?? 0;
        $stock->min_stock_level = $request->min_stock_level ?? 0;
        $stock->max_stock_level = $request->max_stock_level ?? 0;
        $stock->reorder_quantity = $request->reorder_quantity ?? 0;
        $stock->rack_no = $request->rack_no;
        $stock->opening_stock = $request->opening_stock ?? 0;
        if($stock->update()) {
            $stock->warehouse;
            return $stock;
        } else {
            return [];
        }
    }

    public static function getStockDetails($id) {
        return Stock::find($id);
    }
}

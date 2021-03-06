<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareHouse extends Model
{
    use HasFactory, SoftDeletes;

    const LIMIT = 10;
    const ACTIVE = 1;
    
    protected $table = "warehouses";

    protected $fillable = [
        'name',
        'status',
        'shop_id',
        'branch_id',
    ];

    public function stocks() {
        return $this->hasMany(Stock::class);
    }

    public static function addWareHouse($request) {
        $warehouse = new WareHouse;
        $warehouse->name = $request->name;
        $warehouse->shop_id = $request->shop_id;
        $warehouse->branch_id = $request->branch_id;
        $warehouse->status = WareHouse::ACTIVE;
        if($warehouse->save()) {
            return $warehouse;
        } else {
            return [];
        }
    }

    public static function editWareHouseDetails($request) {
        $warehouse = WareHouse::getWareHouseInstance($request->warehouse_id);
        $warehouse->name = $request->name;
        if($warehouse->update()) {
            return $warehouse;
        } else {
            return [];
        }
    }

    public static function warehouseRestore($id) {
        return WareHouse::withTrashed()->where('id', $id)->restore();
    }

    public static function getWareHouseInstance($id) {
        return WareHouse::find($id);
    }

    public static function getAllWareHouses($limit = WareHouse::LIMIT) {
        return WareHouse::paginate($limit);
    }
}

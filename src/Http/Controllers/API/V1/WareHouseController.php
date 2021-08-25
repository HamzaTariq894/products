<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Teamincredibles\Products\Models\WareHouse;
use Teamincredibles\Products\Http\Requests\WareHouseRequest;

class WareHouseController extends Controller
{
    public function addWareHouse(WareHouseRequest $request) {
        $warehouse = WareHouse::addWareHouse($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'WareHouse Added Successfully',
            'data' => $warehouse,
        ]);
    }

    public function editWareHouseDetails(WareHouseRequest $request) {
            $warehouse = WareHouse::editWareHouseDetails($request);
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'WareHouse Updated Successfully',
                'data' => $warehouse,
            ]);
    }

    public function deleteWareHouse(WareHouseRequest $request) {
        $warehouse = WareHouse::getWareHouseInstance($request->warehouse_id);
        if($warehouse == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Warehouse does\'t exists!',
            ]);
        } else {
            $warehouse->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Warehouse Deleted Successfully',
            ]);
        }
    }

    public function warehouseRestore(Request $request) {
        $this->validate($request,[
            'warehouse_id' => 'required|integer',
        ]);
        WareHouse::warehouseRestore($request->warehouse_id); 
        return response([
            'code' => 200,
            'status' => true,
            'message' =>'Warehouse Restored Successfully',
        ]);
    }

    public function getAllWareHouses(Request $request) {
        $warehouses = WareHouse::getAllWareHouses($request->limit);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Success',
            'data' => $warehouses,
        ]);
    }
}

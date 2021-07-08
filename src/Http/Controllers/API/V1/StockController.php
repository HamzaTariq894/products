<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Teamincredibles\Products\Http\Requests\StockRequest;
use Teamincredibles\Products\Models\Stock;

class StockController extends Controller
{
    public function addProductStock(StockRequest $request) {
        $stock = new Stock;
        return $stock->addStock($request);
    }

    public function editProductStocks(StockRequest $request) {
        $stock = Stock::updateProductStocks($request);
        if($stock != null) {
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'Stocks Updated Successfully',
                'data' => $stock,
            ]);
        } else {
            return response([
                'code' => 200,
                'status' => false,
                'message' =>'Sorry! Not Updated',
            ]);
        }
    }

    public function stockDelete(Request $request) {
        $this->validate($request,[
            'stock_id' => 'required|integer',
        ]);
        $stock = Stock::getStockInstance($request->stock_id);
        if($stock == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Stock does\'t exists!',
            ]);
        } else if($stock != null) {
            $stock->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Stock Deleted Successfully',
            ]);
        } else {
                return response([
                'code' => 200,
                'status' => false,
                'message' =>'Invalid Request',
                ]);
        }
    }
}

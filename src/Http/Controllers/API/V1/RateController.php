<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Teamincredibles\Products\Http\Requests\ProductRequest;
use Teamincredibles\Products\Models\Rate;
use Teamincredibles\Products\Models\Product;

class RateController extends Controller
{
    public function addProductRates(ProductRequest $request) {
        $product = Product::getProductInstance($request->product_id);
        if($product != null) {
            $rate = new Rate;
            $new_rate= $rate->associateProductRates($request, $request->product_id);
            if($new_rate != null) {
                return response([
                    'code' => 201,
                    'status' => true,
                    'message' => 'Rates Save Successfully',
                    'data' => $new_rate,
                ]);
            } else {
                return response([
                    'code' => 200,
                    'status' => false,
                    'message' => 'Sorry! Rates Are Not Saved',
                ]);
            }
        } else {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Product does\'t exists!',
                ]);
        }
    }

    public function editProductRates(ProductRequest $request) {
        $product_rates = Rate::updateProductRates($request);
        if($product_rates != null) {
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'Rates Updated Successfully',
                'data' => $product_rates,
            ]);
        } else {
            return response([
                'code' => 200,
                'status' => false,
                'message' =>'Sorry! Not Updated',
            ]);
        }
    }

    public function rateDelete(Request $request) {
        $this->validate($request,[
            'rate_id' => 'required|integer',
        ]);
        $rate = Rate::getRateInstance($request->rate_id);
        if($rate == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Rate does\'t exists!',
            ]);
        } else if($rate != null) {
            $rate->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Rate Deleted Successfully',
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

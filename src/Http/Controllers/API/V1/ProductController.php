<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teamincredibles\Products\Http\Requests\ProductRequest;
use Teamincredibles\Products\Models\Product;

class ProductController extends Controller
{
    public function addProduct(ProductRequest $request) {
        $product = new Product;
        return $product->addProduct($request);
    }

    public function productDelete(Request $request) {
        $this->validate($request,[
            'product_id' => 'required|integer',
        ]);
        $product = Product::getProductInstance($request->product_id);
        if($product == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Product does\'t exists!',
            ]);
        } else {
            $product->delete();
            $product->categories()->detach();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Product Deleted Successfully',
            ]);
        }
    }

    public function editProductDetails(ProductRequest $request) {
        $product = Product::updateProductDetails($request);
        if($product != null) {
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'Product Updated Successfully',
                'data' => $product,
            ]);
        } else {
            return response([
                'code' => 200,
                'status' => false,
                'message' =>'Product Not Updated Successfully',
            ]);
        }
    }

    public function productRestore(Request $request) {
        $this->validate($request,[
            'id' => 'required|integer',
        ]);
        Product::productRestore($request->id); 
        $product = Product::getProductInstance($request->id);
        if(!$product->categories()->where([['category_id', '=' , $product->category_id],['product_id', '=' , $product->id]])->exists()) {
            $product->categories()->attach($product->category_id, ['status' => 1]);
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Product Restored Successfully',
            ]);
        } else {
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Product Already Restored',
            ]);
        }
    }

    public function getAllProducts(Request $request) {
        $products = Product::getAllProducts($request->limit);
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Success',
            'data' => $products,
        ]);
    }

    public function getProductDetails(Request $request) {
        $this->validate($request,[
            'product_id' => 'required|integer',
        ]);
        $product_details = Product::getProductDetails($request->product_id);
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Success',
            'data' => $product_details,
        ]);
    }

    public function compareTwoProducts(Request $request) {
        $this->validate($request,[
            'product_id_1' => 'required|integer',
            'product_id_2' => 'required|integer'
        ]);
        return Product::compareTwoProducts($request);
    }

    public function searchProducts(Request $request) {
        $products = Product::advancedProductSearchForAdmin($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Success',
            'data' => $products,
        ]);
    }

    public function getProductStocks(Request $request) {
        $this->validate($request,[
            'product_id' => 'required|integer'
        ]);
        $product = Product::getProductInstance($request->product_id);
        $stocks = $product->stocks;
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Success',
            'data' => $stocks,
        ]);
    }
}

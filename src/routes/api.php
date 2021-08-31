<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Teamincredibles\Products\Models\Category;
use Teamincredibles\Products\Models\Measurement_Unit;
use Teamincredibles\Products\Models\Product;
use Teamincredibles\Products\Models\Rate;
use Teamincredibles\Products\Models\Stock;
use Teamincredibles\Products\Models\Vendor;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('demo', function() {
    //return Measurement_Unit::find(2);
    return Product::find(6)->categories->pluck('id');
    //return 'hello';
});
    Route::group(['prefix' => 'api/v1/product'],function(){
        Route::post('add/product', [\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'addProduct'])->name('product.add.product');
        //Route::post('add/product/rate', [\Teamincredibles\Products\Http\Controllers\API\V1\RateController::class, 'addProductRates'])->name('product.add.product.rates');
        Route::post('product/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'productDelete'])->name('product.product.delete');
        Route::post('edit/product/details',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'editProductDetails'])->name('product.edit.product.details');
        Route::post('edit/product/rate',[\Teamincredibles\Products\Http\Controllers\API\V1\RateController::class, 'editProductRate'])->name('product.edit.product.rates');
        Route::post('add/product/stock',[\Teamincredibles\Products\Http\Controllers\API\V1\StockController::class, 'addProductStock'])->name('product.add.product.stock');
        Route::post('edit/product/stock',[\Teamincredibles\Products\Http\Controllers\API\V1\StockController::class, 'editProductStocks'])->name('product.edit.product.stocks');
        Route::post('stock/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\StockController::class, 'stockDelete'])->name('product.stock.delete');
        Route::post('rate/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\RateController::class, 'rateDelete'])->name('product.rate.delete');
        Route::get('product/restore',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'productRestore'])->name('product.product.restore');
        Route::get('get/all/products',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'getAllProducts'])->name('product.get.all.products');
        Route::get('get/product/details',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'getProductDetails'])->name('product.get.product.details');       
        Route::post('add/warehouse',[\Teamincredibles\Products\Http\Controllers\API\V1\WareHouseController::class, 'addWareHouse'])->name('product.add.warehouse');       
        Route::post('edit/warehouse/details',[\Teamincredibles\Products\Http\Controllers\API\V1\WareHouseController::class, 'editWareHouseDetails'])->name('product.edit.warehouse.details');       
        Route::post('warehouse/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\WareHouseController::class, 'deleteWareHouse'])->name('product.warehouse.delete');
        Route::get('warehouse/restore',[\Teamincredibles\Products\Http\Controllers\API\V1\WareHouseController::class, 'warehouseRestore'])->name('product.warehouse.restore');
        Route::get('get/all/warehouses',[\Teamincredibles\Products\Http\Controllers\API\V1\WareHouseController::class, 'getAllWareHouses'])->name('product.get.all.warehouses');
        Route::post('add/vendor',[\Teamincredibles\Products\Http\Controllers\API\V1\VendorController::class, 'addVendor'])->name('product.add.vendor');       
        Route::post('update/vendor',[\Teamincredibles\Products\Http\Controllers\API\V1\VendorController::class, 'updateVendor'])->name('product.update.vendor');       
        Route::post('vendor/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\VendorController::class, 'deleteVendor'])->name('product.delete.vendor');       
        Route::post('add/category',[\Teamincredibles\Products\Http\Controllers\API\V1\CategoryController::class, 'addCategory'])->name('product.add.category');       
        Route::post('edit/category/details',[\Teamincredibles\Products\Http\Controllers\API\V1\CategoryController::class, 'editCategoryDetails'])->name('product.edit.category.details');       
        Route::post('category/delete',[\Teamincredibles\Products\Http\Controllers\API\V1\CategoryController::class, 'deleteCategory'])->name('product.category.delete');
        Route::get('category/restore',[\Teamincredibles\Products\Http\Controllers\API\V1\CategoryController::class, 'categoryRestore'])->name('product.category.restore');
        Route::get('get/all/categories',[\Teamincredibles\Products\Http\Controllers\API\V1\CategoryController::class, 'getAllCategories'])->name('product.get.all.categories');
        Route::post('add/measurementunit',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'addMeasurementUnit'])->name('product.add.measurementunit');       
        Route::post('edit/measurementunit/details',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'editMeasurementUnitDetails'])->name('product.edit.measurementunit.details');       
        Route::post('delete/measurementunit',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'deleteMeasurementUnit'])->name('product.measurementunit.delete');
        Route::get('restore/measurementunit',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'measurementUnitRestore'])->name('product.measurementunit.restore');
        Route::get('get/all/measurementunits',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'getAllMeasurementUnits'])->name('product.get.all.measurementunits');
        Route::get('/measurementunits/dropdown/list',[\Teamincredibles\Products\Http\Controllers\API\V1\Measurement_UnitController::class, 'measurementUnitsDropdownList'])->name('product.get.all.measurementunits');
        
        Route::get('compare/two/products', [\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'compareTwoProducts'])->name('product.compare.two.products');        
        Route::get('search/products',[\Teamincredibles\Products\Http\Controllers\API\V1\ProductController::class, 'searchProducts'])->name('product.search.products');
        
    });

?>
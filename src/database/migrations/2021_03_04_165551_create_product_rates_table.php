<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->default(0);
            $table->float('purchase_rate');
            $table->float('sale_rate');
            $table->float('dealer_sale_price');
            $table->float('wholesale_sale_price');
            $table->float('retailer_sale_price');
            $table->integer('shop_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rates');
    }
}

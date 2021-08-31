<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('warehouse_id');
            $table->string('name')->nullable(true);
            $table->integer('quantity');
            $table->integer('preferred_vendor')->default(0);
            $table->integer('min_stock_level')->default(0);
            $table->integer('max_stock_level')->default(0);
            $table->integer('reorder_quantity')->default(0);
            $table->string('rack_no')->nullable(true);
            $table->integer('opening_stock')->default(0);
            $table->boolean('status');
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
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
        Schema::dropIfExists('stocks');
    }
}

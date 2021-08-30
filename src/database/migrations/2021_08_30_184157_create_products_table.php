<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('code');
            $table->unsignedInteger('owner_id');
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('rate_id');
            $table->text('description');
            $table->unsignedInteger('measurement_unit_id');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units');
            $table->foreign('rate_id')->references('id')->on('product_rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

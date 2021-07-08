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
            $table->unsignedInteger('vendor_id')->default(0);
            $table->text('description');
            $table->unsignedInteger('measurement_unit_id')->default(0);
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('measurement_unit_id')->references('id')->on('measurement_units');
            $table->foreign('owner_id')->references('id')->on('users');
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

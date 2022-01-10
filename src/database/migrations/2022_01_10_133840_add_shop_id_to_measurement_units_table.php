<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class AddShopIdToMeasurementUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurement_units', function (Blueprint $table) {
            $table->integer('shop_id')->nullable(true)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurement_units', function (Blueprint $table) {
            $table->dropColumn('shop_id');
        });
    }
}

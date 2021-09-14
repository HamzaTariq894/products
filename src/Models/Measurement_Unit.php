<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement_Unit extends Model
{
    use HasFactory, SoftDeletes;

    const LIMIT = 10;
    const ACTIVE = 1;

    protected $table = "measurement_units";

    protected $fillable = [
        'name', 'status',
    ];

    public function addMeasurementUnit($request) {
        $this->name = $request->name;
        $this->status = Measurement_Unit::ACTIVE;
        $this->save();
    }

    public function products() {
        return $this->hasMany(Product::class, 'measurement_unit_id');
    }

    public static function editMeasurementUnitDetails($request) {
        $measurementunit = Measurement_Unit::getMeasurementUnitInstance($request->measurementunit_id);
        if($measurementunit != null) {
            $measurementunit->name = $request->name;
            $measurementunit->update();
            return $measurementunit;
        }
    }

    public static function measurementUnitRestore($id) {
        return Measurement_Unit::withTrashed()->where('id', $id)->restore();
    }

    public static function getMeasurementUnitInstance($id) {
        return Measurement_Unit::find($id);
    }

    public static function getAllMeasurementUnits($limit = Measurement_Unit::LIMIT) {
        return Measurement_Unit::paginate($limit);
    }

    public static function getmeasurementUnitsDropdownList() {
        $measurementunits = Measurement_Unit::all();
        return collect($measurementunits)->map(function($collection, $key) {
            $collect = (object)$collection;
            return [
                'value' => $collect->id,
                'label' => $collect->name,
            ];
        });
    }

    public static function measurementunitsDetails($measurementunit_id) {
        $counter = count($measurementunit_id);
        $array = [];
        for($i = 0; $i < $counter; $i++) {
            $measurementunit = self::find($measurementunit_id[$i]);
            $array[$i] = $measurementunit;
        }
        $c = array_values($array);
        $collect = collect($c);
        return $collect;
    }
}

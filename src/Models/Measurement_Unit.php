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

    public function product() {
        return $this->belongsTo(Product::class, 'measurement_unit_id');
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
}

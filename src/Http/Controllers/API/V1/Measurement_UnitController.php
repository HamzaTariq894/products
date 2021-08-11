<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Teamincredibles\Products\Http\Requests\Measurement_UnitRequest;
use Teamincredibles\Products\Models\Measurement_Unit;

class Measurement_UnitController extends Controller
{
    public function addMeasurementUnit(Measurement_UnitRequest $request) {
        $measurementunit = new Measurement_Unit;
        $measurementunit->addMeasurementUnit($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Measurementunit Created Successfully',
            'data' => $measurementunit,
        ]);
    }

    public function editMeasurementUnitDetails(Measurement_UnitRequest $request) {
        $measurementunit = Measurement_Unit::editMeasurementUnitDetails($request);
        if($measurementunit != null) {
            return response([
                'code' => 201,
                'status' => true,
                'message' =>'Measurementunit Updated Successfully',
                'data' => $measurementunit,
            ]);
        } else {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Measurementunit does\'t exists!',
            ]);
        }
    }

    public function deleteMeasurementUnit(Measurement_UnitRequest $request) {
        $measurementunit = Measurement_Unit::getMeasurementUnitInstance($request->measurementunit_id);
        if($measurementunit == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'Measurementunit does\'t exists!',
            ]);
        } else {
            $measurementunit->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'Measurementunit Deleted Successfully',
            ]);
        }
    }

    public function measurementUnitRestore(Request $request) {
        $this->validate($request,[
            'measurementunit_id' => 'required|integer',
        ]);
        Measurement_Unit::measurementUnitRestore($request->measurementunit_id); 
        return response([
            'code' => 200,
            'status' => true,
            'message' =>'Measurementunit Restored Successfully',
        ]);
    }

    public function getAllMeasurementUnits(Request $request) {
        $measurementunit = Measurement_Unit::getAllMeasurementUnits($request->limit);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Success',
            'data' => $measurementunit,
        ]);
    }

    public function measurementUnitsDropdownList() {
        $measurementunits = Measurement_Unit::getmeasurementUnitsDropdownList();
        return response([
            'code' => 201,
            'status' => true,
            'message' => 'Success',
            'data' => ['units' => $measurementunits],
        ]);
    }
}


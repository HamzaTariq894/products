<?php

namespace Teamincredibles\Products\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Teamincredibles\Products\Http\Requests\VendorRequest;
use Teamincredibles\Products\Models\Vendor;

class VendorController extends Controller
{
    public function addVendor(VendorRequest $request) {
        $vendor = new Vendor;
        $vendor->addVendor($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Vendor Added Successfully',
            'data' => $vendor,
        ]);
    }

    public function updateVendor(VendorRequest $request) {
        $vendor = Vendor::updateVendor($request);
        return response([
            'code' => 201,
            'status' => true,
            'message' =>'Vendor Updated Successfully',
            'data' => $vendor,
        ]);
    }

    public function deleteVendor(VendorRequest $request) {
        $vendor = Vendor::getVendorInstance($request->vendor_id);
        if($vendor == null) {
            return response([
                'code' => 202,
                'status' => false,
                'message' => 'vendor does\'t exists!',
            ]);
        } else {
            $vendor->delete();
            return response([
                'code' => 200,
                'status' => true,
                'message' =>'vendor Deleted Successfully',
            ]);
        }
    }

    public function vendorRestore(Request $request) {
        $this->validate($request,[
            'vendor_id' => 'required|integer',
        ]);
        Vendor::vendorRestore($request->vendor_id); 
        return response([
            'code' => 200,
            'status' => true,
            'message' =>'vendor Restored Successfully',
        ]);
    }
}

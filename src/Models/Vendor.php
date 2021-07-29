<?php

namespace Teamincredibles\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    const ACTIVE = 1;

    protected $fillable = [
        'name', 
        'status',
        'owner_id',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function addVendor($request) {
        $this->name = $request->vendor_name;
        if($request->has('owner_id')) {
            $this->owner_id = $request->owner_id;
        } else {
            $this->owner_id = Auth::user()->id;
        }
        $this->status = Vendor::ACTIVE;
        $this->save();
    }

    public static function updateVendor($request) {
        $vendor = Vendor::getVendorInstance($request->vendor_id);
        $vendor->name = $request->vendor_name;
        $vendor->status = Vendor::ACTIVE;
        if($vendor->update()) {
            return $vendor;
        } else {
            return [];
        }
    }

    public static function vendorRestore($id) {
        return Vendor::withTrashed()->where('id', $id)->restore();
    }

    public static function getVendorInstance($id) {
        return Vendor::find($id);
    }
}

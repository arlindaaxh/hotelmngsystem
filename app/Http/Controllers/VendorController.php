<?php

namespace App\Http\Controllers;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return $vendors;
    }

    public function store(Request $request)
    {
        $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
      
        $vendor = new Vendor();
        $vendor ->name = $name;
      
        if($vendor->save()){
            // return "success";
            return $vendor;
        }else{
            return "error";
        } 
    }

    public function update(Request $request, $id)
    {   
        $vendor = Vendor::find($id);
        $vendor->update($request->all());

        return response()->json($vendor, 200);
    }

    public function delete($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();         

    }

}

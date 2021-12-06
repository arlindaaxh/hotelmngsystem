<?php

namespace App\Http\Controllers;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    //get all addons
    public function index()
    {
        $addons = Addon::all();
        return $addons;
    }

    //save addon
    public function store(Request $request)
    {
        $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
        $price = $request->input('price');
        $addon = new Addon();
        $addon ->name = $name;
        $addon ->price = $price;
    
        if($addon->save()){
            return "success";
        }else{
            return "error";
        } 
    }

    //edit addon
    public function update(Request $request, $id)
    {
        $addon = Addon::find($id);
        $addon->update($request->all());

        return response()->json($addon, 200);
    }

    //delete addon
    public function delete($id)
    {
        $addon = Addon::findOrFail($id);
        $addon->delete();         
    }
}

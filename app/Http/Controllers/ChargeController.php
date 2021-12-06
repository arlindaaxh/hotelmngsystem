<?php

namespace App\Http\Controllers;
use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{

    //get all charges
    public function index()
    {
        $charges = Charge::all();
        return $charges;
    }
 
    //save charge
    public function store(Request $request)
    {

        $reservation_id = filter_var($request->input('reservation_id'), FILTER_SANITIZE_STRING);
        $room_price = $request->input('room_price');
        $addons = $request->input('addons');
        $total = $request->input('total');

        $charge = new Charge();
        $charge ->reservation_id = $reservation_id;
        $charge ->room_price = $room_price;
        $charge ->addons = $addons;
        $charge ->total = $total;

        if($charge->save()){
            return "success";
        }else{
            return "error";
        } 
    }
 
    //edit charge
    public function update(Request $request, $id)
    {
        $charge = Charge::find($id);
        $charge->update($request->all());

        return response()->json($charge, 200);
    }
 
    //delete charge
    public function delete($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete();         
    }
}

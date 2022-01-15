<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return $rooms;
    }
    //
     //save employee
    public function store(Request $request)
    {
        $type = filter_var($request->input('type'), FILTER_SANITIZE_STRING);
        $code = filter_var($request->input('code'), FILTER_SANITIZE_STRING);
        $number = $request->input('number');
        $status = $request->input('status');
        $facilities = $request->input('facilities');
        $cleaning_status = $request->input('cleaning_status');
        $room_price_per_night =  $request->input('room_price_per_night');

        $room = new Room();
        $room ->type = $type;
        $room ->code = $code;
        $room ->number = $number;
        $room ->status = $status;
        $room ->facilities = $facilities;
        $room->cleaning_status = $cleaning_status;
        $room->room_price_per_night = $room_price_per_night;
 
        if($room->save()){
            return "success";
        }else{
            return "error";
        } 
    }

    
    public function update(Request $request, $id)
    {   
        $room = Room::find($id);
        $room->update($request->all());

        return response()->json($room, 200);
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();         

    }

    public function updateRooms(Request $request)
    {
        $neededData = $request->input('rooms');
        foreach ($neededData as $key=>$value){
            $room = Room::find($value['id']);
            $room->room_price_per_night = $value['room_price_per_night'];
            $room->save();
        }
    }

}

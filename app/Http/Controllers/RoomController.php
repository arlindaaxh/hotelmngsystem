<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;

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
    

         $room = new Room();
         $room ->type = $type;
         $room ->code = $code;
         $room ->number = $number;
         $room ->status = $status;
         $room ->facilities = $facilities;
      
 
         if($room->save()){
             return "success";
         }else{
             return "error";
         } 
     }
}

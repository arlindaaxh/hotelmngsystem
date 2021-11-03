<?php

namespace App\Http\Controllers;
use App\Models\HousekeepingHistory;
use Illuminate\Http\Request;

class HousekeepingHistoryController extends Controller
{
    //

    public function index()
    {
        $schedule = HousekeepingHistory::all();
        return $schedule;
    }
    //
     //save employee
    public function store(Request $request)
    {
        $room_id = filter_var($request->input('room_id'), FILTER_SANITIZE_NUMBER_INT);
        $employee_id = filter_var($request->input('employee_id'), FILTER_SANITIZE_NUMBER_INT);
        $schedule = new HousekeepingHistory();
        $schedule ->room_id = $room_id;
        $schedule ->employee_id = $employee_id;
 
        if($schedule->save()){
            return "success";
        }else{
            return "error";
        } 
    }
    
    public function update(Request $request, $id)
    {   
        $schedule = HousekeepingHistory::find($id);
        $schedule->update($request->all());

        return response()->json($schedule, 200);
    }

    public function delete($id)
    {
        $schedule = HousekeepingHistory::findOrFail($id);
        $schedule->delete();         

    }
}

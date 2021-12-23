<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    //
    public function index()
    {
        $reservations = Reservation::all();
        return $reservations;
    }


    
    public function daily_report(Request $request)
    {
       
        $from = $request->DATE_FROM;
        $to = $request->DATE_TO;

        // dd($from);

        // $reservations = Reservation::whereBetween('date_in', [$from, $to])->get();
        $reservations = Reservation::where('date_in', $from)->where('date_out', $to)->get();
        // where('Column', Value)->where('NewColumn', Value)->get();
        // $reservations = Reservation::whereDate('created_at', '=', $from->toDateString());
        // whereDate('created_at', '=', date('Y-m-d'));
        // $reservations = Reservation::where('date_in', $from)->get();

        // return response()->json($reservations);
        return $reservations;

        // return Reservation::whereBetween('created_at', [
        //     $start_date, $end_date
        // ])->get();
    }

    public function store(Request $request)
    {
        $guest_id = filter_var($request->input('guest_id'), FILTER_SANITIZE_NUMBER_INT);
        $made_by = filter_var($request->input('made_by'), FILTER_SANITIZE_STRING);
        $date_in = $request->input('date_in');
        $date_out = $request->input('date_out');
        $rooms = $request->input('rooms');
        $active = $request->input('active');
        $is_completed = $request->input('is_completed');
     
        $reservation = new Reservation();
        $reservation ->guest_id = $guest_id;
        $reservation ->made_by = $made_by;
        $reservation ->date_in = $date_in;
        $reservation ->date_out = $date_out;
        $reservation ->rooms = $rooms;
        $reservation ->active = $active;
        $reservation ->is_completed = $is_completed;
       
        if($reservation->save()){
            // return "success";
            return $reservation;
        }else{
            return "error";
        } 
    }

    public function update(Request $request, $id)
    {   
        $reservation = Reservation::find($id);
        $reservation->update($request->all());

        return response()->json($reservation, 200);
    }

}

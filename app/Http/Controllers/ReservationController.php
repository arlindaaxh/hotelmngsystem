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
        // $start_date = Reservation::parse($request->date_in)
        //                         ->toDateTimeString();

        // $end_date = Reservation::parse($request->date_out)
        //                         ->toDateTimeString();

        $from = $request->date_in;
        $to = $request->date_out;

        $reservations = Reservation::whereBetween('date_in', [$from, $to])->get();

        // $reservations = Reservation::where('date_in', $from)->get();

        return response()->json($reservations);
        // return $reservations;

        // return Reservation::whereBetween('created_at', [
        //     $start_date, $end_date
        // ])->get();
    }

    // public function getBookings(Request $request)
    // {
    //     $data = Reservation::where('name', 'LIKE','%'.$request->keyword.'%')->get();
    //     return response()->json($data); 

        
    //     return Set::where('type', $type)
    //         ->whereDate('date_in', '<=', date("Y-m-d"))
    //         ->whereDate('date_out', '>=', date("Y-m-d"))
    //         ->first();
    // }

    public function store(Request $request)
    {
        $guest_id = filter_var($request->input('guest_id'), FILTER_SANITIZE_NUMBER_INT);
        $made_by = filter_var($request->input('made_by'), FILTER_SANITIZE_STRING);
        $date_in = $request->input('date_in');
        $date_out = $request->input('date_out');
        $rooms = $request->input('rooms');
        $active = $request->input('active');
     
        $reservation = new Reservation();
        $reservation ->guest_id = $guest_id;
        $reservation ->made_by = $made_by;
        $reservation ->date_in = $date_in;
        $reservation ->date_out = $date_out;
        $reservation ->rooms = $rooms;
        $reservation ->active = $active;
       
        if($reservation->save()){
            // return "success";
            return $reservation;
        }else{
            return "error";
        } 
    }

}

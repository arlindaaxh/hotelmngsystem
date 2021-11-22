<?php

namespace App\Http\Controllers;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    //get all guests
    public function index()
    {
        $guests = Guest::all();
        return $guests;
    }

    //save guest
    public function store(Request $request)
    {
        $first_name = filter_var($request->input('first_name'), FILTER_SANITIZE_STRING);
        $last_name = filter_var($request->input('last_name'), FILTER_SANITIZE_STRING);
        $email = filter_var($request->input('email'), FILTER_SANITIZE_EMAIL);
        $address = filter_var($request->input('address'), FILTER_SANITIZE_STRING);
        $phone_number = filter_var($request->input('phone_number'), FILTER_SANITIZE_STRING);
        $birth_date = $request->input('birth_date');
        $personal_number = filter_var($request->input('personal_number'), FILTER_SANITIZE_STRING);
        $citizenship = filter_var($request->input('citizenship'), FILTER_SANITIZE_STRING);
        $sex = filter_var($request->input('sex'), FILTER_SANITIZE_STRING);

        $guest = new Guest();
        $guest ->first_name = $first_name;
        $guest ->last_name = $last_name;
        $guest ->email = $email;
        $guest ->address = $address;
        $guest ->phone_number = $phone_number;
        $guest ->birth_date = $birth_date;
        $guest ->personal_number = $personal_number;
        $guest ->citizenship = $citizenship;
        $guest ->sex = $sex;

        if($guest->save()){
            // return "success";
            return $guest;
        }else{
            return "error";
        } 
    }
}

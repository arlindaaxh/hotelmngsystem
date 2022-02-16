<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {
        $orders = Order::all();
        return $orders;
    }
    //
     //save employee
    public function store(Request $request)
    {
        $serial_number = $request->input('serial_number');
        $items = $request->input('items');
        $products = $request->input('products');
        $total_amount = $request->input('total_amount');
        $payment_type = $request->input('payment_type');
        $guest_id = $request->input('guest_id');
        $employee_id =  $request->input('employee_id');
        $status = $request->input('status');
        $initial_qty = $request->input('initial_qty');

        $order = new Order();
        $order ->serial_number = $serial_number;
        $order ->items = $items;
        $order ->products = $products;
        $order ->total_amount = $total_amount;
        $order ->payment_type = $payment_type;
        $order->guest_id = $guest_id;
        $order->employee_id = $employee_id;
        $order->status = $status;
        $order->initial_qty = $initial_qty;
 
        if($order->save()){
            return $order;
        }else{
            return "error";
        } 
    }
}

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
    

        $order = new Order();
        $order ->serial_number = $serial_number;
        $order ->items = $items;
        $order ->products = $products;
        $order ->total_amount = $total_amount;
        $order ->payment_type = $payment_type;
        $order->guest_id = $guest_id;
        $order->employee_id = $employee_id;
        $order->status = $status;

 
        if($order->save()){
            return $order;
        }else{
            return "error";
        } 
    }

    public function update(Request $request, $id)
    {   
        $order = Order::find($id);
        $order->update($request->all());

        return response()->json($order, 200);
    }

    public function updateOrderStatuses(Request $request)
    {
        $neededData = $request->input('orders');
        foreach ($neededData as $key=>$value){
            $order = Order::find($value['id']);
            $order->status = $value['status'];
            $order->save();
        }
    }

}

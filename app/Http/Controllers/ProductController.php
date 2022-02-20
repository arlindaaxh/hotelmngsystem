<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    public function store(Request $request)
    {
        $name = filter_var($request->input('name'), FILTER_SANITIZE_STRING);
        $price = $request->input('price');
        $upc = $request->input('upc');
        $vendor_id = $request->input('vendor_id');
        $initial_quantity = $request->input('initial_quantity');

     
        $product = new Product();
        $product ->name = $name;
        $product ->price = $price;
        $product ->upc = $upc;
        $product ->vendor_id = $vendor_id;
        $product ->initial_quantity = $initial_quantity;
      
        if($product->save()){
            // return "success";
            return $product;
        }else{
            return "error";
        } 
    }

    public function update(Request $request, $id)
    {   
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();         

    }

   

    public function searchProd(Request $request){
                //$dogs = Dogs::latest()->take(50)->get();
        $products = Product::where('name', 'LIKE','%'.$request->input('keyword').'%')->get();
        return $products;
    }  

    public function getMostSoldProducts(){
        
        // $sales = Product::with('sales')
        // ->leftJoin('orders','products.id','=','orders.product_id')
        // ->selectRaw('products.*, COALESCE(sum(orders.item_count),0) total')
        // ->groupBy('products.id')
        // ->orderBy('total','desc')
        // ->take(5)
        // ->get();


        
        DB::table('products')
            ->select([
                'products.id',
                'products.name',
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM( products.price * order_product.qty) AS total_price'),
            ])
            ->join('order_product', 'order_product.product_id', '=', 'products.id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status','approved')
            ->groupBy('products.id')
            ->orderByDesc('total_sales')
            ->get();
         

        //     $products = Product::all();

        //     $orders = Order::all();

        // $neededData = $request->input('orders');
        // foreach ($orders as $key=>$value){
        //     $order = Order::find($value['id']);
        //     $soldprods =  $value['products'];
        //     foreach($soldprods as $key=>$value){

        //     }
        //     $order->status = $value['status'];
        //     $order->save();
        // }

   }
   
   
}

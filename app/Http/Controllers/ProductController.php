<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

   
   
}

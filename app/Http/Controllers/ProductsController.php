<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Products::all();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json(['name' => 'create','Status' => 'Succes']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductsRequest $request)
    {
        //
        return response()->json(['name' => 'store', 'payload' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {   
        //
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
        return response()->json(['name' => 'edit', 'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductsRequest $request, Products $products)
    {
        //
        return response()->json(['name' => 'update', 'payload' => $request->all(), 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
        return response()->json(['name' => 'destroy', 'id' => $id]);
    }

    public function login(Request $request){
        $user = User::where('name', $request->name)->latest('created_at')->first();
        if($user->password!= $request->password){
            return response()->json(['Status' => 'error']);
        }
        return response()->json(['Status' => 'Success', 'Data' => $user]);
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'product_id'=>'required',
            'product_name'=>'required',
            'price'=>'required'
        ]);
        $data = array();
        $data['product_id'] = $request->product_id;
        $data['product_name'] = $request->product_name;
        $data['price'] = $request->price;

        DB::table('products')->insert($data);
        return response()->json(['Status' => 'Success', 'Data' => $data]);
    }

    public function deleteProduct(Request $request)
    {
        $data = Products::select('*')->where('id', $request->id)->latest('created_at')->first();
        // return response()->json($data);
        if($data){
            $data->delete(); 
        }else{
            return response()->json(['Status' => 'error']);
        }
        return response()->json(['Status' => 'Success', 'Data' => null]); 

    }

    public function updateProduct(Request $request)
    {
        $product=Products::find($request->id);
        $product->update($request->all());
        return $product;

      
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;

        DB::table('users')->insert($data);
        return response()->json(['Status' => 'Success', 'Data' => $data]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        
        // Cách 1: return only item ( cũ chuối )
        // return $products->map(function($product) {
        //     return collect($product -> toArray())
        //     ->only(['id', 'name', 'description'])
        //     ->all();
        // });

        // Cách 2: Chuối ni xịn hơn => dùng
        $products = $products->map->only('id', 'name', 'description')->toArray();
        return response()->json([
            'msg' => 'success',
            'results' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
       // Cach 1: gán từng thằng => hơi chuối
        // $product->name = $request->name;
        // $product->description = $request->description;
        // $product->price = $request->price;
        // $product->save();

        // Cách 2: Ịn thằng fillable vào model cho xịn xò
        $product = $product->create($request->all());
        return response()->json([
            'msg' => 'success',
            'result' => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $products = Product::find($id);
       return response()->json([
           'msg' => 'success',
           'result' => $products
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $result = $product->update($request->all());
        return response()->json([
            'msg' => 'success',
            'result' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'msg' => 'success'
        ]); 
    }
}

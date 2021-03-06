<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Product;
use App\Helpers\APIHelpers;
use App\Http\Requests\SaveProductRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchText = $request->searchText;
        $perPage = $request->perPage ?? 10;
        $sortBy = 'created_at';
        $sortType = 'ASC';
        if ($request->has('name')) {
            $sortBy = 'name';
            $sortType = $request->name ?? 'asc';
        } else if ($request->has('price')) {
            $sortBy = 'price';
            $sortType = $request->price ?? 'asc';
        }
        try {
            $products = Product::orderBy($sortBy, $sortType)->paginate($perPage);
            if ($searchText) {
                $products = Product::where('name', 'LIKE', '%' .$searchText. '%')->orderBy($sortBy, $sortType)->orWhere('created_at', 'LIKE', '%' .$searchText. '%')->paginate($perPage);
            }
            return APIHelpers::createAPIResponse(true, 200, '', $products, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 401, '', null, $e->getmessage());
        }
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
    public function store(SaveProductRequest $request)
    {
        $product = new Product();
       // Cach 1: gán từng thằng => hơi chuối
        // $product->name = $request->name;
        // $product->description = $request->description;
        // $product->price = $request->price;
        // $product->save();

        // Cách 2: Ịn thằng fillable vào model cho xịn xò
        
        try {
            $product = $product->create($request->all());
            return APIHelpers::createAPIResponse(true, 201, 'Product added successfully', $product, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, 'Product added failed', null, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $msg = 'Get product detail failed';
        try {
            $product = Product::find($id);
            if ($product) {
                return APIHelpers::createAPIResponse(true, 201, '', $product, null);
            } else {
                return APIHelpers::createAPIResponse(true, 401, $msg, null, null);
            }
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, $msg, null, $e->getMessage());
        }
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
    public function update(SaveProductRequest $request, $id)
    {
        $msg = 'ProductId not found';
        $msgUpdatedFail = 'Updated product failed';
        try {
            $product = Product::find($id);
            if ($product) {
                $result = $product->update($request->all());
                return APIHelpers::createAPIResponse(true, 201, '', $product, null);
            } else {
                return APIHelpers::createAPIResponse(false, 401, $msg, null, null);
            }
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, $msgUpdatedFail, null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $msg = 'ProductId not found';
        $msgDeleleFail = 'Delete product failed';
        try {
            $product = Product::find($id);
            if ($product) {
                $product->delete();
                return APIHelpers::createAPIResponse(true, 201, '', null, null);
            } else {
                return APIHelpers::createAPIResponse(false, 401, $msg, null, null);
            }
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, $msgDeleleFail, null, $e->getMessage());
        }
    }

    public function getProductByCategory($nIdCategory) {
        $cat = Product::find($nIdCategory);
        if ($cat) {
            $cat['category'] = $cat->category;
            try {
                return APIHelpers::createAPIResponse(true, 200, 'Get product by category successfully!', $cat, null);
            }  catch (\Exception $e) {
                return APIHelpers::createAPIResponse(false, 400, 'Get product by category failed!', null, $e->getMessage());
            }
        } else {
            return APIHelpers::createAPIResponse(false, 401, 'Id category not found!', null, null);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\v1;

use App\Categories;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use App\Http\Requests\CategoriesRequest;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        try {
            $category = $categories->map->only('nIdCategory', 'title', 'description')->toArray();
            return APIHelpers::createAPIResponse(true, 200, '', $category, null);
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
    public function store(CategoriesRequest $request)
    {
        $category = new Categories();
        try {
            $category = $category->create($request->all());
            return APIHelpers::createAPIResponse(true, 201, 'Category added successfully', $category, null);
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, 'Category added failed', null, $e->getMessage());
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
        $msg = 'Get category detail failed';
        try {
            $category = Categories::find($id);
            if ($category) {
                return APIHelpers::createAPIResponse(true, 201, '', $category, null);
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
    public function update(CategoriesRequest $request, $id)
    {
        $msg = 'category not found';
        $msgUpdatedFail = 'Updated category failed';
        try {
            $category = Categories::find($id);
            if ($category) {
                $result = $category->update($request->all());
                return APIHelpers::createAPIResponse(true, 201, '', $category, null);
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
        $msg = 'Category not found';
        $msgDeleleFail = 'Delete category failed';
        try {
            $category = Categories::find($id);
            if ($category) {
                $category->delete();
                return APIHelpers::createAPIResponse(true, 201, 'Deleted category successfully', null, null);
            } else {
                return APIHelpers::createAPIResponse(false, 401, $msg, null, null);
            }
        } catch (\Exception $e) {
            return APIHelpers::createAPIResponse(false, 400, $msgDeleleFail, null, $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Category::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name'                                           => 'required|string',
            'is_active'                                      => 'required|string',

        ];

        $this->validate($request,$rules);

            $category = Category::create($request->all());


            return $this->showOne($category, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($param)
    {
        if (is_numeric($param)) {
            $category = Category::where('id', $param)->first();
            return $category === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($category);
        } else {
            $category = Category::where('slug', $param)->where('state', 'approved')->first();
            return $category === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($category);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name'                                           => 'required|string',
            'is_active'                                      => 'required|string',

        ];

        $this->validate($request, $rules);


        if ($request->has('name'))
            $category->name = $request->name;
        if ($request->has('is_active'))
            $category->is_active = $request->is_active;

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }


        $category->save();
        return $this->showOne($category);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->showOne($category);
    }
}

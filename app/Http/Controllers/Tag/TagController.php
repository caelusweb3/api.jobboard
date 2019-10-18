<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\ApiController;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Tag::all());
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

        $category = Tag::create($request->all());


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
            $tag = Tag::where('id', $param)->first();
            return $tag === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($tag);
        } else {
            $tag = Tag::where('slug', $param)->where('state', 'approved')->first();
            return $tag === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($tag);
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
    public function update(Request $request, Tag $tag)
    {
        $rules = [
            'name'                                           => 'required|string',
            'is_active'                                      => 'required|string',

        ];

        $this->validate($request, $rules);


        if ($request->has('name'))
            $tag->name = $request->name;
        if ($request->has('is_active'))
            $tag->is_active = $request->is_active;

        if ($tag->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }


        $tag->save();
        return $this->showOne($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return $this->showOne($tag);
    }
}

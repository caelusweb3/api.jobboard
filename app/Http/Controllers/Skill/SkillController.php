<?php

namespace App\Http\Controllers\Skill;

use App\Http\Controllers\ApiController;
use App\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkillController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Skill::all());
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

        $category = Skill::create($request->all());


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
            $skill = Skill::where('id', $param)->first();
            return $skill === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($skill);
        } else {
            $skill = Skill::where('slug', $param)->where('state', 'approved')->first();
            return $skill === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($skill);
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
    public function update(Request $request, Skill $skill)
    {
        $rules = [
            'name'                                           => 'required|string',
            'is_active'                                      => 'required|string',

        ];

        $this->validate($request, $rules);


        if ($request->has('name'))
            $skill->name = $request->name;
        if ($request->has('is_active'))
            $skill->is_active = $request->is_active;

        if ($skill->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }


        $skill->save();
        return $this->showOne($skill);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return $this->showOne($skill);
    }
}
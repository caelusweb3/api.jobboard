<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\ApiController;
use App\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showAll(Team::all());
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

        $category = Team::create($request->all());


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
            $team = Team::where('id', $param)->first();
            return $team === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($team);
        } else {
            $team = Team::where('slug', $param)->where('state', 'approved')->first();
            return $team === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($team);
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
    public function update(Request $request, Team $team)
    {
        $rules = [
            'name'                                           => 'required|string',
            'is_active'                                      => 'required|string',

        ];

        $this->validate($request, $rules);


        if ($request->has('name'))
            $team->name = $request->name;
        if ($request->has('is_active'))
            $team->is_active = $request->is_active;

        if ($team->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }


        $team->save();
        return $this->showOne($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return $this->showOne($team);
    }
}

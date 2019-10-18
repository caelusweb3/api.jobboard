<?php

namespace App\Http\Controllers\Job;

use App\Day;
use App\Employer;
use App\Job;
use App\Skill;
use App\Team;
use App\Transformers\JobTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;


class JobController extends ApiController
{

    public function __construct() {
        parent::__construct();

        $this->middleware('transform.input:' . JobTransformer::class)->only(['store', 'update']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDrafts($slug)
    {

        $employer = Employer::where('slug', $slug)->first();

        $jobs=Job::where('employer_id','=',$employer->id)->where('taslak','=',"1")->get();

        return $this->showAll($jobs);


    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTowns()
    {
        $towns=DB::table('town')->where('CityID','=',40)->get();

        return response()->json($towns);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('current') && $request->current == 'true') {

            return $this->showAll(Job::where('created_at', '<', Carbon::now())->orderBy('begin_date', 'desc')->limit(5)->get());
        }

        return $this->showAll(Job::all());
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
            'title'                                      => 'required|string',
            'work_style'                                 => 'required|in:' . Job::GUNLUK . ',' . Job::FREELANCE . ',' . Job::PART_TIME,
            'address'                                    => 'string',
            'fee'                                        => 'required|integer',
            'description'                                => 'required|string',
            'category_id'                                => 'required|exists:categories,id',
            'wear'                                       => 'string',
            'tool'                                       => 'string',
            'tarif'                                      => 'string',
            'province'                                   => 'string',
            'city'                                       => 'string',
            'week_day'                                   => 'string',
            'taslak'                                     => 'string'


        ];



        $this->validate($request, $rules);
        $data=$request->all();


        if ($request->work_style == 'Part Time'){
            $data['category_id'] = $request->category_id;
            if($request->person_count==null)
                $data['person_count'] =   "Belirsiz";
            else
                $data['person_count'] = $request->person_count;
            if($request->wear==null)
                $data['wear'] =   "Belirsiz";
            else
                $data['wear'] = $request->wear;
            if($request->tool==null)
                $data['tool'] =   "Belirsiz";
            else
                $data['tool'] = $request->tool;

            $data['description'] = $request->description;
            $data['fee'] = $request->fee;
            if($request->address==null)
                $data['address']  =   "Belirsiz";
            else
                $data['address']  = $request->address;

            $data['week_day']  = $request->week_day;
            $data['work_style']=$request->work_style;
            $data['tarif']=$request->tarif;
            $data['begin_date']=$request->begin_date;
            $data['employer_id']=$request->employer_id;
            $data['province']=$request->province;
            $data['city']=$request->city;
            if ($request->has('taslak'))
                $data['taslak']=$request->taslak;
            else
                $data['taslak']="0";



        }



        else if ($request->work_style == 'Günlük'){
            $data['category_id'] = $request->category_id;
            if($request->person_count==null)
                $data['person_count'] =   "Belirsiz";
            else
                $data['person_count'] = $request->person_count;
            if($request->wear==null)
                $data['wear'] =   "Belirsiz";
            else
                $data['wear'] = $request->wear;
            if($request->tool==null)
                $data['tool'] =   "Belirsiz";
            else
                $data['tool'] = $request->tool;

            $data['description'] = $request->description;
            $data['fee'] = $request->fee;
            $data['work_style']=$request->work_style;
            $data['tarif']=$request->tarif;

            if($request->address==null)
                $data['address']  =   "Belirsiz";
            else
                $data['address']  = $request->address;
            $data['employer_id']=$request->employer_id;
            $data['province']=$request->province;
            $data['city']=$request->city;
            $data['begin_date']=$request->tarih1;
            if ($request->has('taslak'))
                $data['taslak']=$request->taslak;
            else
                $data['taslak']="0";


        }



        $job = Job::create($data);






        if (!empty($request->tarih1) && $request->work_style =='Günlük') {

            if (!empty($request->tarih1)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih1;
                $job->begin_date=$request->tarih1;
                $day1->save();
            }

            if (!empty($request->tarih2)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih2;
                $job->begin_date=$request->tarih1;
                $day1->save();
            }

            if (!empty($request->tarih3)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih3;
                $day1->save();
            }

            if (!empty($request->tarih4)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih4;
                $day1->save();
            }


        }

        $job->save();

        if (count($request->skills)>0) {

            for ($i=0; $i<count($request->skills);$i++){
                $job->skills()->syncWithoutDetaching([$request->skills[$i]]);

            }
        }


        $team=new Team;
        $team->name=$job->title;
        $team->job_id=$job->id;
        $team->employer_id=$job->employer_id;
        $team->save();


        return $this->showOne($job, 201);

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
            $job = Job::where('id', $param)->first();
            return $job === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($job);
        } else {
            $job = Job::where('slug', $param)->first();
            return $job === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($job);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {

        $request->validate([
            'title'                                      => 'string',
            'work_style'                                 => 'in:' . Job::GUNLUK . ',' . Job::FREELANCE . ',' . Job::PART_TIME,
            'address'                                    => 'string',
            'fee'                                        => 'integer',
            'description'                                => 'string',
            'category_id'                                => 'exists:categories,id',
            'person_count'                               => 'string',
            'wear'                                       => 'string',
            'tool'                                       => 'string',
            'tarif'                                      => 'string',
            'province'                                   => 'string',
            'week_day'                                   => 'string',
            'city'                                       => 'string',
            'taslak'                                     => 'string',
            'kiyafet'                                    => 'string'


        ]);

        if ($request->has('title'))
            $job->title = $request->title;
        if ($request->has('category_id'))
            $job->category_id = $request->category_id;
        if ($request->has('wear'))
            $job->wear = $request->wear;

        if ($request->has('skills') && count($request->skills)>0) {
            foreach ($request->skills as $skill) {
                $job->skills()->syncWithoutDetaching([$skill]);
            }
        }
        if($request->has('city'))
            $job->city = $request->city;

        if($request->has('province'))
            $job->province = $request->province;

        if ($request->has('tool'))
            $job->tool = $request->tool;

        if ($request->has('work_style'))
            $job->work_style = $request->work_style;
        if ($request->has('address'))
            $job->address = $request->address;
        if ($request->has('fee'))
            $job->fee = $request->fee;

        if ($request->has('person_count'))
            $job->person_count = $request->person_count;


        if($request->has('description'))
            $job->description = $request->description;
        if (!empty($request->tarih1)  && $job->work_style=="Günlük"){

            if ($request->has('week_day'))
                $job->week_day = $request->week_day;
            $job->days()->delete();
            if (!empty($request->tarih1)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih1;
                $job->begin_date=$request->tarih1;
                $day1->save();
            }

            if (!empty($request->tarih2)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih2;
                $job->begin_date=$request->tarih1;
                $day1->save();
            }

            if (!empty($request->tarih3)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih3;
                $day1->save();
            }

            if (!empty($request->tarih4)){
                $day1= new Day();
                $day1->job_id=$job->id;
                $day1->day1=$request->tarih4;
                $day1->save();
            }
        }


        if (count($request->skills)>0) {
            $job->skills()->detach();
            for ($i=0; $i<count($request->skills);$i++){
                $job->skills()->syncWithoutDetaching([$request->skills[$i]]);

            }
        }


        $job->save();
        return $this->showOne($job);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return $this->showOne($job);
    }
}

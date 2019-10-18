<?php

namespace App\Http\Controllers\Employer;

use App\Employer;
use App\Http\Controllers\ApiController;
use App\Transformers\EmployerTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;
use Crypt;


class EmployerController extends  ApiController
{


    public function __construct() {


       // $this->middleware('transform.input:' . EmployerTransformer::class)->only(['store', 'update']);
    }

    //Daha önce çalıştığı tüm işçiler
    public function getEmployerUsers($slug)
    {

         //$jobs=$employer->jobs()->where('begin_date','<',Carbon::now())->get();

       // dd($jobs);
        return $this->showAll(Employer::all());
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Employer::findOrFail(21);
       $jobs = $employer->jobs()->where('begin_date','<',Carbon::now())->get();
       return $this->showAll(Employer::all());
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
            'name'                                       => 'required|string',
            'email'                                      => 'required|email|unique:employers',
            'password'                                   => 'required|min:6',


        ];


        $this->validate($request,$rules);

        $data = $request->all();
        $data['image'] = 'user.png';
        $data['password'] = bcrypt($request->password);


        $employer = Employer::create($data);

        File::isDirectory(public_path() . '/Employers/' . $employer->id) or File::makeDirectory(public_path() . '/Employers/' . $employer->id, 0775, true, true);
        File::copy(public_path() . '/default/user.png', public_path() . '/Employers/' . $employer->id . '/user.png');



        return $this->showOne($employer, 201);

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
            $employer = Employer::where('id', $param)->first();
            return $employer === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($employer);
        } else {
            $employer = Employer::where('slug', $param)->first();
            return $employer === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($employer);
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
    public function update(Request $request, Employer $employer)
    {
        $rules = [
            'name'                                       => 'string',
            'email'                                      => 'email',
            'password'                                   => 'min:6',
            'address'                                    => 'string',
            'phone'                                      => 'string',
            'employer_info'                              => 'string',
            'image'                                      => 'string',
            'province'                                   => 'string',
            'city'                                       => 'string',
            'verified'                                   => 'in:' . Employer::VERIFIED_USER . ',' . Employer::UNVERIFIED_USER,

        ];


        $this->validate($request, $rules);


        if ($request->has('name'))
            $employer->name = $request->name;
        if ($request->has('email'))
            $employer->email = $request->email;
        if ($request->has('password'))
            $employer->password = bcrypt($request->password);
        if ($request->has('address'))
            $employer->address = $request->address;
        if($request->has('phone'))
            $employer->phone = $request->phone;
        if($request->has('employer_info'))
            $employer->employer_info =$request->employer_info;
        if($request->has('facebook'))
            $employer->facebook =$request->facebook;
        if($request->has('twitter'))
            $employer->twitter =$request->twitter;
        if($request->has('linkedin'))
            $employer->linkedin =$request->linkedin;
        if($request->has('website'))
            $employer->website =$request->website;
        if($request->has('instagram'))
            $employer->instagram =$request->instagram;
        if ($request->has('province'))
            $employer->province = $request->province;
        if ($request->has('city'))
            $employer->city = $request->city;
        if ($request->has('first_login'))
            $employer->first_login = $request->first_login;


        if ($request->has('verified'))
            $employer->verified = $request->verified;

        if ($request->has('image-data') ) {
            $image_data = $request->get('image-data');

            $info = base64_decode(preg_replace('#data:image/\w+;base64,#i', '',$image_data));
            $img1=Image::make($info);
            $filename=$employer->id.time().'.png';

            $saved=$img1->save(public_path().'/Employers/'.$employer->id.'/'.$filename);

            File::delete(public_path().'/Employers/'.$employer->id.'/'.$employer->image);
            $employer->image=$filename;
        }



        $employer->save();
        return $this->showOne($employer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employer = Employer::findOrFail($id);
        $employer->delete();

        return $this->showOne($employer);
    }
}

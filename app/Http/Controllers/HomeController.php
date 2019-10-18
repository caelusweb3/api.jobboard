<?php

namespace App\Http\Controllers;

use App\Employer;
use App\Transformers\EmployerTransformer;
use App\User;
use Illuminate\Http\Request;

class HomeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isExist(Request $request)
    {


        $user = User::where('email', $request->email)->first();


        if ($user!=null)
            return $this->showOne($user);
        else
            return response()->json();

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isExistE(Request $request)
    {


        $user = Employer::where('email', $request->email)->first();
        if ($user!=null)
            return $this->showOne($user);
        else
            return response()->json();

    }

}

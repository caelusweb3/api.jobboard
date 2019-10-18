<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\User;
use App\Employer;
use App\Role;
use Illuminate\Support\Str;
use App\Transformers\userTransformer;

use Hash;
use Redirect;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
class AuthController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('client.credentials')->only(['destroy', 'logout','register','login']);
    }

    public function register(Request $req){

        $req->validate([
            'name'=>'required',
            'surname'=>'required',
            'birth'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:6'

        ]);
        $user = new User([
            'name'=>$req->name,
            'surname'=>$req->surname,
            'birth'=>$req->birth,
            'email'=>$req->email,
            'password'=>bcrypt($req->password),



        ]);

        $user
            ->roles()
            ->attach(Role::where('name', 'Regular User')->first());

        $user->save();

        return response()->json($user);

    }


    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);

         if (Auth::guard('employer')->attempt($credentials)) {

            $employer = Auth::guard('employer')->user();
            $token = Str::random(60);
             $employer->api_token=hash('sha256', $token);
            $token = $employer->api_token;
            $employer->save();

             return response()->json([
                 'access_token' => $token,
                 'token_type' => 'Token',
                 'data' => $employer
             ]);

        }


        else if (Auth::attempt($credentials)){


        $user = $request->user();
        $token = Str::random(60);
        $user->api_token=hash('sha256', $token);
        $token = $user->api_token;
        $user->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Token',
            'data' => $user
        ]);
        }

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

    }






    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

/////////////////////////////////////////////////////////////////






}

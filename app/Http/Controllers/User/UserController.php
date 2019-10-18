<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Crypt;
use File;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->showAll(User::all());
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
            'surname'                                    => 'required|string',
            'email'                                      => 'required|email|unique:users',
            'password'                                   => 'required|min:6',

        ];

        $this->validate($request,$rules);

        $data = $request->all();

        $data['image'] = 'user.png';
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();

        $user = User::create($data);


        File::isDirectory(public_path() . '/Users/' . $user->id) or File::makeDirectory(public_path() . '/Users/' . $user->id, 0775, true, true);
        File::copy(public_path() . '/default/user.png', public_path() . '/Users/' . $user->id . '/user.png');


        return $this->showOne($user, 201);

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
            $user = User::where('id', $param)->first();
            return $user === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($user);
        } else {
            $user = User::where('slug', $param)->first();
            return $user === null ? $this->errorResponse('Does not exists any job with the specified identificator', 404) : $this->showOne($user);
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
    public function update(Request $request, User $user)
    {


        $rules = [
            'name'                                       => 'string',
            'surname'                                    => 'string',
            'email'                                      => 'email|unique:employers',
            'age'                                        => 'integer',
            'phone'                                      => 'integer',
            'province'                                   => 'string',
            'city'                                       => 'string',
            'image'                                      => 'string',
            'address'                                    => 'string',
            'personal_info'                              => 'string',
            'verified'                                   => 'in:' . User::VERIFIED_USER . ',' . User::UNVERIFIED_USER,
            'first_login'                                => 'string'
        ];


        $this->validate($request, $rules);


        if ($request->has('name'))
            $user->name = $request->name;
        if($request->has('surname'))
            $user->surname = $request->surname;
        if ($request->has('email'))
            $user->email = $request->email;
        if ($request->has('password'))
            $user->password = bcrypt($request->password);
        if($request->has('gender'))
            $user->gender = $request->gender;
        if ($request->has('age'))
            $user->age = $request->age;
        if ($request->has('province'))
            $user->province = $request->province;
        if ($request->has('city'))
            $user->city = $request->city;
        if ($request->has('address'))
            $user->address = $request->address;
        if($request->has('phone'))
            $user->phone = $request->phone;
        if($request->has('first_login'))
            $user->first_login = $request->first_login;
        if($request->has('personal_info'))
            $user->personal_info =$request->personal_info;
        if ($request->has('verified'))
            $user->verified = $request->verified;

        if ($request->has('image-data') ) {
            $image_data = $request->get('image-data');

            $info = base64_decode(preg_replace('#data:image/\w+;base64,#i', '',$image_data));
            $img1=Image::make($info);
            $filename=$user->id.time().'.png';

            $saved=$img1->save(public_path().'/Users/'.$user->id.'/'.$filename);

            File::delete(public_path().'/Users/'.$user->id.'/'.$user->image);
            $user->image=$filename;
        }



        $user->save();
        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->showOne($user);
    }



    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($token) {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->save();

        return $this->showMessage('Hesabınız başarıyla doğrulanmıştır');
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function resend(User $user) {
        if ($user->isVerified())
            return $this->errorResponse('Bu kullanıcının e-postası daha önceden doğrulanmıştır.', 409);

        retry(5, function () use ($user) {
            Mail::to($user)->send(new UserCreated($user));
        }, 100);
        return $this->showMessage('Doğrulama e-postası tekrar gönderilmiştir.');
    }
}

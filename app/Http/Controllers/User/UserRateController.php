<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Rate;
use App\User;
use Laravel\Passport\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRateController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(User  $user)
    {
        return $this->showAll($user->rates);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user=User::findOrFail($id);
        $rate = new Rate;
        $rate->point=$request->rating;
        $rate->job_id=$request->job_id;
        $rate->save();

        if (count($request->tags)!=0){
            foreach ($request->tags as $tag){

                $rate->tags()->syncWithoutDetaching([$tag]);
            }

        }

        $user->rates()->syncWithoutDetaching([$rate->id]);

        $result = 0;
        foreach ($user->rates as $rate){

            $result = $result + $rate->point;
        }
        $user->rate=$result / count($user->rates);
        $user->save();

        return $this->showAll($user->rates);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate,User $user)
    {
        if (!$user->favorites()->find($rate->id)) {
            return $this->errorResponse('The specified user is not a participant of this event', 404);
        }
        $user->favorites()->detach($rate->id);
        return $this->showAll($user->rates);
    }
}

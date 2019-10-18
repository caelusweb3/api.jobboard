<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserFavoritesController extends ApiController
{


    public function __construct() {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(User  $user)
    {
        return $this->showAll($user->favorites);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user,Job $job)
    {
        $user->favorites()->syncWithoutDetaching([$job->id]);
        return $this->showAll($user->favorites);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job,User $user)
    {
        if (!$user->favorites()->find($job->id)) {
            return $this->errorResponse('The specified user is not a participant of this event', 404);
        }
        $user->favorites()->detach($job->id);
        return $this->showAll($user->favorites());
    }
}

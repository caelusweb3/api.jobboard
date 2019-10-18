<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\ApiController;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(Job  $job)
    {
        return $this->showAll($job->users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Job $job, User $user)
    {
        $job->users()->syncWithoutDetaching([$user->id]);
        return $this->showAll($job->users,201);

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
        if (!$job->users()->find($user->id)) {
            return $this->errorResponse('The specified user is not a participant of this event', 404);
        }
        $job->users()->detach($user->id);
        return $this->showAll($job->users);
    }
}

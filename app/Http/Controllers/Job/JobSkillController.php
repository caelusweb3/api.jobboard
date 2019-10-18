<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\ApiController;
use App\Job;
use App\Skill;
use Illuminate\Http\Request;

class JobSkillController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function index(Job  $job)
    {
        return $this->showAll($job->skills);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Job $job, Skill $skill)
    {
        $job->users()->syncWithoutDetaching([$skill->id]);
        return $this->showAll($job->skills);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job,Skill $skill)
    {
        if (!$job->users()->find($skill->id)) {
            return $this->errorResponse('The specified user is not a participant of this event', 404);
        }
        $job->users()->detach($skill->id);
        return $this->showAll($job->skills);
    }
}

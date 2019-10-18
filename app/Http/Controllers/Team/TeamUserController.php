<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\ApiController;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Team $team
     * @return \Illuminate\Http\Response
     */
    public function index(Team $team)
    {
        return $this->showAll($team->t_users);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Team $team, User $user)
    {
        $team->users()->syncWithoutDetaching([$user->id]);
        return $this->showAll($team->users);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $team
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team,User $user)
    {
        if (!$team->users()->find($user->id)) {
            return $this->errorResponse('The specified user is not a participant of this event', 404);
        }
        $team->users()->detach($user->id);
        return $this->showAll($team->users);
    }
}

<?php

namespace App\Transformers;

use App\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Team $team)
    {

        return [
        'identifier'         => (integer)$team->id,
        'job'                => $team->jobs,
         'jobDetails'        => $team->jobs->slug,
        'job_id'             => $team->job_id,
        'employer_id'        => $team->employer_id,
         'users'             => fractal()->collection($team->users)->transformWith(new UserTransformer()),
        'name'               => (string) $team->name,
        'is_active'          => (string) $team->is_active,
        'created_at'         => (string) $team->created_at,
        'updated_at'         => (string) $team->updated_at,
        'deleted_at'         => isset($team->deleted_at) ? (string) $team->deleted_at : null,

    ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'job_id'            => 'job_id',
            'employer_id'       => 'employer_id',
            'name'              => 'name',
            'is_active'         => 'is_active',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id'                => 'identifier',
            'name'              => 'name',
            'is_active'         => 'is_active',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

<?php

namespace App\Transformers;

use App\Employer;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class EmployerTransformer extends TransformerAbstract
{


    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Employer $employer)
    {
        $jobs=$employer->jobs()->where('begin_date','<',Carbon::now())->get();
        $jobs_users=$employer->jobs()->where('begin_date','<',Carbon::now())->get();
        $active_jobs=$employer->jobs()->where('begin_date','>',Carbon::now())->get();


        $users = null;
        foreach ($employer->jobs as $job){
            $users=collect($users)->merge($job->users);

        }

        return [
            'identifier'     => (int)$employer->id,
            'name'           => (string)$employer->name,
            'email'          => (string)$employer->email,
            'password'       => (string)$employer->password,
            'phone'          => (string)$employer->phone,
            'address'        => (string)$employer->address,
            'addressDetails'  => [
                'city' => (string) $employer->city,
                'province'=> (string) $employer->province

            ],
            'employer_info'  => (string)$employer->employer_info,
            'instagram'      => (string)$employer->instagram,
            'allEmployee'    => fractal()->collection($users)->transformWith(new UserTransformer()),
            'facebook'      => (string)$employer->facebook,
            'twitter'       => (string)$employer->twitter,
            'website'       => (string)$employer->website,
            'linkedin'       => (string)$employer->linkedin,
            'surname'        => false,
            'past_jobs'          => fractal()->collection($jobs)->transformWith(new JobTransformer()),
            'teams'              => fractal()->collection($employer->teams)->transformWith(new TeamTransformer()),
            'jobs'               => fractal()->collection($employer->jobs)->transformWith(new JobTransformer()),
            'active_jobs'        => fractal()->collection($active_jobs)->transformWith(new JobTransformer()),
            'image'              => url('/Employers/' . $employer->id . '/' . $employer->image),
            'created_at'      => (string)$employer->created_at,
            'updated_at'      => (string)$employer->updated_at,
            'deleted_at'       => isset($employer->deleted_at) ? (string) $employer->deleted_at : null,

            ];
    }


    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'name'              => 'name',
            'surname'           => 'surname',
            'email'             => 'email',
            'password'          => 'password',
            'phone'             => 'phone',
            'image'             => 'image',
            'address'           => 'address',
            'employer_info'     => 'employer_info',
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
            'surname'           => 'surname',
            'email'             => 'email',
            'password'          => 'password',
            'phone'             => 'phone',
            'image'             => 'image',
            'address'           => 'address',
            'employer_info'     => 'employer_info',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

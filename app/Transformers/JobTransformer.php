<?php

namespace App\Transformers;

use App\Job;
use function GuzzleHttp\Psr7\str;
use League\Fractal\TransformerAbstract;

class JobTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Job $job)
    {
        return [
            'identifier'      => (int)$job->id,
            'category_id'     => (int)$job->category_id,
            'categoryDetails'   => [
                'id'  => (integer)$job->categories->id,
                'name'  => (string)$job->categories->name
            ],
            'employer_id'     => (int) $job->employer_id,
            'person_count'    => (string)$job->person_count,
            'title'           => (string)$job->title,
            'work_style'      => (string)$job->work_style,
            'address'         => (string)$job->address,
            'addressDetails'  => [
                'city' => (string) $job->city,
                'province'=> (string) $job->province

            ],
             'images'              => url('/Employers/' . $job->employer_id . '/' . $job->employers->image),
            'users'          => fractal()->collection($job->users)->transformWith(new UserTransformer()),
            'days'            => $job->days,
            'skills'          => $job->skills,
            'team'          => $job->teams,
            'employer'      => $job->employers,
            'taslak'          => (string)$job->taslak,
            'wear'            => (string)$job->wear,
            'tool'            => (string)$job->tool,
            'fee'             => (integer)$job->fee,
            'description'     => (string)$job->description,
            'slug'            => (string)$job->slug,
            'begin_date'      => (string)$job->begin_date,
            'week_day'        => (string) $job->week_day,
            'created_at'      => (string)$job->created_at,
            'timeDetails'   => [
                'time'  => (string)$job->created_at->diffForHumans(),
            ],
            'updated_at'      => (string)$job->updated_at,
            'deleted_at'       => isset($job->deleted_at) ? (string) $job->deleted_at : null,
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'category_id'       => 'category_id' ,
            'employer_id'       => 'employer_id',
            'person_count'      => 'person_count',
            'wear'              => 'wear',
            'categoryDetails'   => 'categoryDetails',
            'addressDetails'    =>  'addressDetails',
            'tool'              => 'tool',
            'title'             => 'title',
            'work_style'        => 'work_style',
            'address'           => 'address',
            'fee'               => 'fee',
            'slug'              => 'slug',
            'description'       => 'description',
            'tarih1'             =>'tarih1',
            'tarih2'            => 'tarih2',
            'tarih3'            => 'tarih3',
            'tarih4'            => 'tarih4' ,
            'week_day'         => 'week_day',
            'province'          => 'province',
            'city'              =>  'city',
            'taslak'            =>  'taslak',
            'skills'            =>  'skills',
            'begin_date'        => 'begin_date',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id'                => 'identifier',
            'category_id'       => 'category_id' ,
            'employer_id'       => 'employer_id',
            'person_count'      => 'person_count',
            'wear'              => 'wear',
            'tool'              => 'tool',
            'title'             => 'title',
            'work_style'        => 'work_style',
            'address'           => 'address',
            'categoryDetails'   => 'categoryDetails',
            'addressDetails'    =>  'addressDetails',
            'fee'               => 'fee',
            'slug'              => 'slug',
            'description'       => 'description',
            'tarih1'             =>'tarih1',
            'tarih2'            => 'tarih2',
            'tarih3'            => 'tarih3',
            'tarih4'            => 'tarih4' ,
            'week_day'         => 'week_day',
            'province'          => 'province',
            'city'              =>  'city',
            'skills'            =>  'skills',
            'taslak'            =>  'taslak',
            'begin_date'        => 'begin_date',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',


        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

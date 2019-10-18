<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier'         => (int)$user->id,
            'name'               => (string)$user->name,
            'surname'            => (string)$user->surname,
            'email'              => (string)$user->email,
            'password'           => (string)$user->password,
            'gender'             => (integer)$user->gender,
            'age'                => (integer)$user->age,
            'apply_count'        => count($user->jobs),
            'rate'               => $user->rate,
            'phone'              => (string)$user->phone,
            'addressDetails'  => [
                'city' => (string) $user->city,
                'province'=> (string) $user->province

            ],
            'jobs'                => $user->jobs,
            'teams'               => $user->teams,
            'rates'               => $user->rates,
            'address'            => (string)$user->address,
            'slug'               => (string) $user->slug,
            'image'              => url('/Users/' . $user->id . '/' . $user->image),
            'personal_info'      => (string)$user->personal_info,
            'verified'           => (string)$user->verified,
            'created_at'         => (string)$user->created_at,
            'updated_at'         => (string)$user->updated_at,
            'deleted_at'         => isset($user->deleted_at) ? (string) $user->deleted_at : null,

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
            'address'           => 'address',
            'gender'            => 'gender',
            'rate'              => 'rate',
            'age'               => 'age',
            'image'             => 'image',
            'slug'              => 'slug',
            'verified'          => 'verified',
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
            'address'           => 'address',
            'gender'            => 'gender',
            'age'               => 'age',
            'rate'              => 'rate',
            'image'             => 'image',
            'slug'              => 'slug',
            'verified'          => 'verified',
            'employer_info'     => 'employer_info',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

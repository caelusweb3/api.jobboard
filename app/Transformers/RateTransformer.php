<?php

namespace App\Transformers;

use App\Rate;
use League\Fractal\TransformerAbstract;

class RateTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Rate $rate)
    {
        return [
            'identifier'         => (integer)$rate->id,
            'name'               => (integer) $rate->point,
            'created_at'         => (string) $rate->created_at,
            'updated_at'         => (string) $rate->updated_at,
            'deleted_at'         => isset($rate->deleted_at) ? (string) $rate->deleted_at : null,

        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'point'             => 'point',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index) {
        $attributes = [
            'id'                => 'identifier',
            'point'             => 'point',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

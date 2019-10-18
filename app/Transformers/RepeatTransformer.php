<?php

namespace App\Transformers;

use App\Repeat;
use League\Fractal\TransformerAbstract;

class RepeatTransformer extends TransformerAbstract
{ /**
 * A Fractal transformer.
 *
 * @return array
 */
    public function transform(Repeat $repeat)
    {
        return [
            'identifier'         => (integer)$repeat->id,
            'name'               => (integer) $repeat->point,
            'is_active'          => (string) $repeat->is_active,
            'created_at'         => (string) $repeat->created_at,
            'updated_at'         => (string) $repeat->updated_at,
            'deleted_at'         => isset($repeat->deleted_at) ? (string) $repeat->deleted_at : null,

        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'point'             => 'point',
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
            'point'             => 'point',
            'is_active'         => 'is_active',
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

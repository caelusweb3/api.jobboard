<?php

namespace App\Transformers;

use App\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tag $tag)
    {
        return [
            'identifier'         => (integer)$tag->id,
            'name'               => (string) $tag->name,
            'is_active'          => (string) $tag->is_active,
            'created_at'         => (string) $tag->created_at,
            'updated_at'         => (string) $tag->updated_at,
            'deleted_at'         => isset($tag->deleted_at) ? (string) $tag->deleted_at : null,

        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
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

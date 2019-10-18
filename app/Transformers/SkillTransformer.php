<?php

namespace App\Transformers;

use App\Skill;
use League\Fractal\TransformerAbstract;

class SkillTransformer extends TransformerAbstract
{
    public function transform(Skill $skill)
    {
        return [
            'identifier'         => (integer)$skill->id,
            'name'               => (string) $skill->name,
            'is_active'          => (string) $skill->is_active,
            'created_at'         => (string) $skill->created_at,
            'updated_at'         => (string) $skill->updated_at,
            'deleted_at'         => isset($skill->deleted_at) ? (string) $skill->deleted_at : null,

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

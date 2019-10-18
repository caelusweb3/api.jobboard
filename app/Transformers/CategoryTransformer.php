<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier'         => (integer)$category->id,
            'name'               => (string) $category->name,
            'is_active'          => (string) $category->is_active,
            'created_at'         => (string) $category->created_at,
            'updated_at'         => (string) $category->updated_at,
            'deleted_at'         => isset($category->deleted_at) ? (string) $category->deleted_at : null,

        ];
    }


    public static function originalAttribute($index) {
        $attributes = [
            'identifier'        => 'id',
            'name'              => 'name',
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
            'created_at'        => 'created_at',
            'updated_at'        => 'updated_at',
            'deleted_at'        => 'deleted_at',

        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }


}

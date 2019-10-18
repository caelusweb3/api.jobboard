<?php

namespace App;

use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;


    const ACTIVE ="aktif";
    const NOT_ACTIVE="aktif değil";

    protected $dates = ['deleted_at'];
    public $transformer = CategoryTransformer::class;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'is_active',
    ];


    public function jobs() {
        return $this->hasMany(Job::class);
    }




}

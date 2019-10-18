<?php

namespace App;

use App\Transformers\TagTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;


    const ACTIVE ="aktif";
    const NOT_ACTIVE="aktif değil";


    protected $dates = ['deleted_at'];
    public $transformer = TagTransformer::class;
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function rates(){
        return $this->belongsToMany(Rate::class, 'rate_tags');
    }
}

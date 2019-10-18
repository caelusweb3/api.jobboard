<?php

namespace App;

use App\Transformers\RepeatTransformer;
use Illuminate\Database\Eloquent\Model;

class Repeat extends Model
{
    protected $dates = ['deleted_at'];
    public $transformer = RepeatTransformer::class;
    protected $table = 'repeats';

    protected $fillable = [
        'name',
        'active',
    ];

    public function jobs() {
        return $this->belongsTo(Job::class,'repeat_id');
    }
}

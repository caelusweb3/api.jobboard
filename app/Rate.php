<?php

namespace App;

use App\Transformers\RateTransformer;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $dates = ['deleted_at'];
    public $transformer = RateTransformer::class;
    protected $table = 'rates';

    protected $fillable = [

        'point',
        'time',
        'behaviour',
        'performance'

    ];

    public function tags(){
        return $this->belongsToMany(Tag::class, 'rate_tags');
    }

    public function users() {
        return $this->belongsToMany(User::class,'rate_user');
    }

    public function jobs() {
        return $this->belongsTo(Job::class,'job_id');
    }
}

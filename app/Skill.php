<?php

namespace App;

use App\Transformers\SkillTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $transformer = SkillTransformer::class;
    protected $table = 'skills';

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function jobs() {
        return $this->belongsToMany(Job::class,'job_skills');
    }
}

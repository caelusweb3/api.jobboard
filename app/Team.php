<?php

namespace App;

use App\Transformers\TeamTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{

    use SoftDeletes;

    const ACTIVE ="aktif";
    const NOT_ACTIVE="aktif değil";


    protected $dates = ['deleted_at'];
    public $transformer = TeamTransformer::class;
    protected $table = 'teams';

    protected $fillable = [
        'job_id',
        'employer_id',
        'name',
        'is_active',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'team_users');
    }

    public function t_users() {
        return $this->belongsToMany(User::class, 'team_users');
    }

    public function jobs() {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employers() {
        return $this->belongsTo(Employer::class, 'employer_id');
    }


}

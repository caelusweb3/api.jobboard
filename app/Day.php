<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{


    protected $table = 'days';
    protected $fillable = [
        'job_id',
        'day1',
        'day2',
        'day3',
        'day4'

    ];


    public function jobs() {
        return $this->belongsTo(Job::class, 'job_id');
    }
}

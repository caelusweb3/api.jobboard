<?php

namespace App;

use App\Transformers\JobTransformer;
use App\Traits\ApiResponser;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes,HasSlug;

    const GUNLUK = 'Günlük';
    const PART_TIME = 'Part Time';
    const FREELANCE = 'freelance';






    protected $dates = ['deleted_at'];
    public $transformer = JobTransformer::class;
    protected $table = 'jobs';

    protected $fillable = [
        'employer_id',
        'category_id',
        'wear',
        'tool',
        'person_count',
        'title',
        'work_style',
        'address',
        'fee',
        'description',
        'begin_date',
        'week_day',
        'slug',
        'city',
        'province',
        'taslak'

    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom(['title'])
            ->saveSlugsTo('slug');
    }



    public function users() {
        return $this->belongsToMany(User::class, 'job_users');
    }

    public function teams() {
        return $this->hasOne(Team::class);
    }

    public function rates() {
        return $this->hasMany(Rate::class);
    }

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function user() {
        return $this->belongsToMany(User::class,'favorites_jobs','job_id','user_id');
    }

    public function skills() {
        return $this->belongsToMany(Skill::class,'job_skills');
    }


    public function categories() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function employers(){
        return $this->belongsTo(Employer::class,'employer_id');
    }

    public function repeats(){
        return $this->hasMany(Repeat::class);
    }



}

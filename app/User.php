<?php

namespace App;

use App\Transformers\UserTransformer;
use Laravel\Passport\HasApiTokens;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes,HasSlug;


    const MALE = '1';
    const FEMALE = '0';


    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const EMPLOYER = '1';
    const CANDIDATE = '0';

    const FIRST_LOGIN = '1';
    const NOT_FIRST_LOGIN = '0';

    public $transformer = UserTransformer::class;


    protected $table = 'users';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'gender',
        'age',
        'phone',
        'image',
        'address',
        'verified',
        'verification_token',
        'personal_info',
        'first_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];


    // Mutators and Accessor
    public function setNameAttribute($name) {
        $this->attributes['name'] = mb_strtolower($name);
    }

    public function getNameAttribute($name) {
        return ucwords($name);
    }

    public function setSurnameAttribute($surname) {
        $this->attributes['surname'] = mb_strtolower($surname);
    }

    public function getSurnameAttribute($surname) {
        return ucwords($surname);
    }

    public function setEmailAttribute($email) {
        $this->attributes['email'] = mb_strtolower($email);
    }

    // Other Methods
    public function isVerified() {
        return $this->verified == User::VERIFIED_USER;
    }

    public static function generateVerificationCode() {
        return str_random(40);
    }



    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'surname'])
            ->saveSlugsTo('slug');
    }

    public function jobs() {
        return $this->belongsToMany(Job::class, 'job_users');
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'team_users');
    }

    public function rates() {
        return $this->belongsToMany(Rate::class,'rate_user');
    }

    public function favorites() {
        return $this->belongsToMany(Job::class, 'favorites_jobs');
    }



}

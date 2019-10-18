<?php

namespace App;

use App\Notifications\EmployerResetPassword;
use App\Transformers\EmployerTransformer;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SMartins\PassportMultiauth\HasMultiAuthApiTokens;

class Employer extends Authenticatable
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


    protected $table = 'employers';
    protected $dates = ['deleted_at'];
    public $transformer = EmployerTransformer::class;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','first_login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployerResetPassword($token));
    }


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


    public function jobs() {
        return $this->hasMany(Job::class);
    }

    public function teams() {
        return $this->hasMany(Team::class);
    }


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug');
    }
}

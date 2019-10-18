<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('towns','Job\JobController@getTowns');


Route::resource('teams','Team\TeamController');

Route::resource('team.users','Team\TeamUserController');

/**
 * Jobs Routes
 */
Route::resource('jobs','Job\JobController');
Route::resource('jobs.users','Job\JobUserController');
Route::resource('jobs.skills','Job\JobSkillController');
Route::get('todayJobs','Job\JobController@todayJobs');
Route::get('drafts/{slug}','Job\JobController@getDrafts');


/**
 * Employers Routes
 */
Route::resource('employers','Employer\EmployerController');
Route::get('employerUsers/{slug}','Employer\EmployerController@getEmployerUsers');



/**
 * Categories Routes
 */
Route::resource('categories','Category\CategoryController');

/**
 * Skills Routes
 */
Route::resource('skills','Skill\SkillController');


/**
 * Users Routes
 */
Route::resource('users','User\UserController');

Route::put('users/{id}/rates','User\UserRateController@update');
Route::resource('users.rates','User\UserRateController');
Route::resource('users.jobs','User\UserFavoritesController');
Route::post('isexistuser','HomeController@isExist');
Route::post('isexistemployer','HomeController@isExistE');


/**
 * Users Routes
 */
Route::resource('tags','Tag\TagController');

Route::post('get_token','Auth\AuthController@login');

Route::middleware('auth:api')->get('/auser', function(Request $request) {
    return $request->user();
});


/**
 * Others
 */
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::post('auth/register','Auth\AuthController@register');
Route::post('auth/login','Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');
Route::get('user', 'Auth\AuthController@user');

Route::get('/me', function () {
    return response()->json(['data' => \Illuminate\Support\Facades\Auth::user()]);
})->middleware('auth:api');
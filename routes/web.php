<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'employer'], function () {
  Route::get('/login', 'EmployerAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'EmployerAuth\LoginController@login');
  Route::post('/logout', 'EmployerAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'EmployerAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'EmployerAuth\RegisterController@register');

  Route::post('/password/email', 'EmployerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'EmployerAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'EmployerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'EmployerAuth\ResetPasswordController@showResetForm');
});

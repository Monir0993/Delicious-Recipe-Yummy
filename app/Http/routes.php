<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('login','HomeController@login');
Route::post('login','HomeController@authenticate');
Route::get('logout','HomeController@logout');

Route::get('registration','HomeController@registration');
Route::post('registration','HomeController@store');

Route::resource('search','RecipeController');
Route::post('details','RecipeController@details');

Route::group(['middleware'=>['isAuth']],function(){
    Route::resource('/','HomeController');
    Route::post('add-to-favorite','HomeController@addToFavourite');
    Route::get('delete-favourite/{id}','HomeController@deleteFavourite');
});

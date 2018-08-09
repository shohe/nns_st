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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/users', 'UsersController');
Route::post('/users/image/', 'UsersController@store_image'); // Store image and update user's image information
Route::delete('/users/image/{id}', 'UsersController@destroy_image'); // {$user_id} -> Destroy image if user have image and update user's image information
Route::get('/users/salon/{id}', 'UsersController@salon_info'); // {$stylist_id} -> get stylist's salon information

Route::resource('/offers', 'OffersController');
Route::get('/offers/received/{id}', 'OffersController@received'); // {$stylist_id} -> get all offers muched from customers

Route::resource('/requests', 'RequestsController');
Route::get('/requests/received/{id}', 'RequestsController@received'); // {$customers_id} -> get all requests customer reseived
Route::get('/requests/detail/{id}', 'RequestsController@detail'); // {$request_id} -> get detail of the request for customer's offer
Route::get('/requests/history/{id}', 'RequestsController@history'); // {$customers_id} -> get all requests history customer reseived
Route::get('/requests/history/detail/{id}', 'RequestsController@history_detail'); // {$request_id} -> get detail of requests history customer reseived

Route::resource('/reviews', 'ReviewsController');

Route::resource('/charities', 'CharitiesController');
Route::get('/charities/all/{id}', 'CharitiesController@with_user_id'); // {$customers_id} -> get all requests history customer reseived
Route::get('/charities/check/{id}', 'CharitiesController@check_is_close'); // {$customers_id} -> check if user selected the charity closed already

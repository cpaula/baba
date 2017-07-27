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


Route::post('register', 'Api\Auth\RegisterController@register');
//Route::post('register', ['as' => 'register', 'uses' => 'Api\Auth\RegisterController@register']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

Route::get('/', function () {
    return view('welcome');
});

$api->version('v1', function($api) {
	$api->get('hello', 'App\Http\Controllers\Controller@index');
	//$api->get('hello1', 'App\Http\Controllers\Controller@hello');
	$api->get('users/{user_id}/roles/{role_name}', 'App\Http\Controllers\Controller@attachUserRole');
	$api->get('users/{user_id}/roles', 'App\Http\Controllers\Controller@getUserRole'); 
	//$api->get('hello', 'App\Http\Controllers\HomeController@index')->middleware('auth');
	$api->post('role/permission/add', 'App\Http\Controllers\Controller@attachPermission');
	$api->post('role/permission', 'App\Http\Controllers\Controller@getPermissions');


});
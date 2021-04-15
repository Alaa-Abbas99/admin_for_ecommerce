<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

//By default created 

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');


Route::group(['middleware' => 'auth:api'], function(){
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('user', 'App\Http\Controllers\UserController@user');
    Route::put('users/info', 'App\Http\Controllers\UserController@updateInfo');
    Route::put('users/password', 'App\Http\Controllers\UserController@updatePassword');
    Route::post('/upload' , 'App\Http\Controllers\ImageController@upload');
    Route::get('/export', 'App\Http\Controllers\OrderController@export');
    Route::get('/chart', 'App\Http\Controllers\DashboardController@chart');


    Route::apiResource('/users', 'App\Http\Controllers\UserController');
    Route::apiResource('/roles', 'App\Http\Controllers\RoleController');
    Route::apiResource('/products', 'App\Http\Controllers\ProductController');
    Route::apiResource('/orders', 'App\Http\Controllers\OrderController')->only('index', 'show');
    Route::apiResource('/permissions', 'App\Http\Controllers\PermissionController')->only('index');
});

// This syntax below didn't work 

// Route::middleware('auth:api')-> gorup( function(){
//     Route::apiResource('/users', 'App\Http\Controllers\UserController');
// });


//The One Above Substitutes All Below 


    // Route::get('/users', 'App\Http\Controllers\UserController@index');

    // Route::get('/users/{user}', 'App\Http\Controllers\UserController@show');
    // Route::post('/users/create', 'App\Http\Controllers\UserController@store');
    // Route::put('/users/{user}/update', 'App\Http\Controllers\UserController@update');
    // Route::delete('/users/{user}/destroy', 'App\Http\Controllers\UserController@destroy');

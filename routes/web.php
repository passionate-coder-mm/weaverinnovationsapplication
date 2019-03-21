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

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->middleware('verified');

Route::get('/admin-dashboard', 'HomeController@index');
Route::get('/user-dashboard', 'HomeController@waitingforvarification');

Route::group(['prefix' => 'user'], function () {
    Route::resource('user_options', 'Admin\UserController');
    Route::get('getdesignation/{deptid}','Admin\UserController@getdesigbyid');
    Route::get('uniqueemailchk','Admin\UserController@unqemailchk');
    Route::get('getuserinfo/{userid}','Admin\UserController@getuserinfobyid');
    Route::get('getusereditinfo/{userid}','Admin\UserController@getusereditinfo');
    Route::post('updateuser','Admin\UserController@update');
    Route::get('deleteuser/{userid}','Admin\UserController@destroy');

});
Route::group(['prefix' => 'department'], function () {
    Route::resource('department_options', 'Admin\DepartmentController');
    Route::get('uniquenametest','Admin\DepartmentController@unqnamecheck');
    Route::get('deletedept/{deptid}','Admin\DepartmentController@destroy');
    Route::get('getdeptinfo/{deptid}','Admin\DepartmentController@departmentdetails');
});

Route::group(['prefix' => 'designation'], function () {
    Route::resource('designation_options', 'Admin\DesignationController');
    Route::get('remainingdepartment/{deptid}','Admin\DesignationController@remainingdepartment');
    Route::post('updatedesignation','Admin\DesignationController@update');
    Route::get('deletedesig/{designationid}','Admin\DesignationController@destroy');
});
Route::group(['prefix' => 'role'], function () {
    Route::resource('role_options','Admin\RoleController');
    Route::post('updaterole','Admin\RoleController@update');
    Route::get('uniquetest','Admin\RoleController@uniqueroletest');
});

Route::group(['prefix' =>'team'], function () {
    Route::resource('team_options', 'Admin\TeamController');
    Route::get('getdatabyteam/{teamid}','Admin\TeamController@getdatabyteam');
    Route::get('makeexecutiveteamless/{exid}/{teamid}','Admin\TeamController@removeuserfromteam');
    Route::post('updateteam','Admin\TeamController@update');
    Route::get('updateteamstatus/{id}/{teamid}','Admin\TeamController@updateteamstatus');
    Route::get('getteaminfobyid/{teamid}','Admin\TeamController@getteaminfobyteam');
});
    

// Route::get('/home', 'HomeController@index')->name('home');

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
// Route::get('/home', 'HomeController@index')->middleware('verified');

Route::get('/admin-dashboard', 'HomeController@index');
Route::get('userprofile/{slug}','HomeController@showProfile');
Route::get('/user-dashboard', 'HomeController@waitingforvarification');

Route::group(['prefix' => 'user'], function () {
    Route::resource('user_options', 'Admin\UserController');
    Route::get('getdesignation/{deptid}','Admin\UserController@getdesigbyid');
    Route::get('uniqueemailchk','Admin\UserController@unqemailchk');
    Route::get('getuserinfo/{userid}','Admin\UserController@getuserinfobyid');
    Route::get('getusereditinfo/{userid}','Admin\UserController@getusereditinfo');
    Route::post('updateuser','Admin\UserController@update');
    Route::get('deleteuser/{userid}','Admin\UserController@destroy');
    Route::get('loginhistory','Admin\UserController@loginhistoty');
});
Route::group(['prefix' => 'department'], function () {
    Route::resource('department_options', 'Admin\DepartmentController');
    Route::get('uniquenametest','Admin\DepartmentController@unqnamecheck');
    Route::get('deletedept/{deptid}','Admin\DepartmentController@destroy');
    Route::get('getdeptinfo/{deptid}','Admin\DepartmentController@departmentdetails');
    Route::get('removeassmanager/{assmng}/{deptid}','Admin\DepartmentController@removeassistantmanager');
    Route::get('removemember/{memberid}/{deptid}','Admin\DepartmentController@removemember');
    Route::post('updatedepartmentinfo','Admin\DepartmentController@update');
    Route::get('changeolddeptmng/{managerid}','Admin\DepartmentController@changedepartmentrowmng');
    
});

Route::group(['prefix' => 'designation'], function () {
    Route::resource('designation_options', 'Admin\DesignationController');
    Route::get('remainingdepartment/{deptid}','Admin\DesignationController@remainingdepartment');
    Route::post('updatedesignation','Admin\DesignationController@update');
    Route::get('deletedesig/{designationid}','Admin\DesignationController@destroy');
    Route::get('uniqdesignation/{teamid}/{designation}','Admin\DesignationController@uniqnamechk');
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
    Route::get('uniqteamname','Admin\TeamController@unqnamechk');
    Route::get('uniqteamnameforedit','Admin\TeamController@unqnameforedit');
});


Route::group(['prefix' =>'attendances'], function () {
    Route::resource('attendance', 'Admin\AttendanceController');
    Route::get('uniqueattchk','Admin\AttendanceController@unqattidchk');
    Route::get('uniqueuserchk/{user_id}','Admin\AttendanceController@unquserchk');
    Route::get('updateuserattstatus/{id}/{teamid}','Admin\AttendanceController@activedeactiveoption');
    Route::get('attendancefilter','Admin\AttendanceController@showattendancefilter');
    Route::get('dailyattendance/{attendanceid}/{inorout}','Admin\AttendanceController@userdailyattendance');
    Route::post('datewiseattendance','Admin\AttendanceController@datewiseappendance');
    Route::post('datewise_complete_attendance_summary','Admin\AttendanceController@datewiseallemployeeattendance');
    Route::get('datewisecompleteattendance','Admin\AttendanceController@showallattendancehistory');
});

Route::group(['prefix' =>'leave'], function () {
    Route::resource('leave_options','Admin\LeaveRequestController');
    Route::post('notification/read','Admin\LeaveRequestController@read');
    Route::get('leaveapproval/{id}/{uniqueidentification}','Admin\LeaveRequestController@approvalblade');
    Route::post('leaveorlateapproval','Admin\LeaveRequestController@leaveorlateapproval');
    Route::get('disapprove/{id}','Admin\LeaveRequestController@disapprove');
    Route::get('allleavebyid','Admin\LeaveRequestController@allleaverequest');
    Route::get('approveleavefrommng/{id}/{type}','Admin\LeaveRequestController@approvefrommng');
    Route::get('detailrequest/{id}/{type}','Admin\LeaveRequestController@detailrequest');
    Route::get('checkdate/{startdate}/{enddate}','Admin\LeaveRequestController@checkdaterange');
    Route::get('checkdateexistance/{leavedate}/{userid}','Admin\LeaveRequestController@checkleaverequestdate');
    
});
   Route::post('getnotifications','Admin\LeaveRequestController@getallNotifications');
 Route::group(['prefix' =>'holyday'], function () {
    Route::resource('holyday-option','Admin\HolydayController');
    Route::post('updateholyday','Admin\HolydayController@update');
    Route::get('deleteholyday/{id}','Admin\HolydayController@destroy');

 });
 Route::group(['prefix' =>'transport'], function () {
    Route::resource('transport-voucher','Admin\TransportVoucherController');
    Route::get('getallbillinfoByid/{id}','Admin\TransportVoucherController@getallbillinfobyId');
    Route::get('makemessagezero/{id}/{userrole}','Admin\TransportVoucherController@makemessagecountZero');
    Route::get('singlemessage/{id}','Admin\TransportVoucherController@showsingledetailbill');
    Route::get('approveconveyancebymng/{id}/{notifiable}/{role}','Admin\TransportVoucherController@approveconveyanceBysuperior');
    Route::get('allpayabletransportBilllist','Admin\TransportVoucherController@allpaybleTransportbill');
    Route::get('sendforreview/{unqid}','Admin\TransportVoucherController@reviewit');
    Route::post('updatebillinfo','Admin\TransportVoucherController@update');
});
Route::group(['prefix' =>'cash'], function () {
    Route::resource('cash-voucher','Admin\CashVoucherController');
    Route::get('getallcashbillinfoByid/{unqid}','Admin\CashVoucherController@getallcashinfo');
    Route::post('updatecashinfo','Admin\CashVoucherController@update');
    Route::get('singlemessage/{id}','Admin\CashVoucherController@showsingledetailcashbill');
    Route::get('approvecash/{unqid}/{notifiable}/{role}','Admin\CashVoucherController@approvecashBysuperior');
    Route::get('sendforreview/{unqid}','Admin\CashVoucherController@reviewit');
    Route::get('settlerequestdata/{unqid}','Admin\CashVoucherController@settlerequestdata');
    Route::post('sendsettlerequest','Admin\CashVoucherController@sendsettleRequest');
    Route::get('singlemessageforexpense/{unqid}','Admin\CashVoucherController@singlecashsettle');
    Route::get('approveexpense/{unqid}/{notifiable}/{role}','Admin\CashVoucherController@approveadvanceSettle');
    Route::get('sendexpenseforreview/{unqid}','Admin\CashVoucherController@reviewexpense');
    Route::get('getadvancesettlelist/{unqid}','Admin\CashVoucherController@settlelistforadvance');
    Route::post('upgradesettlerequest','Admin\CashVoucherController@updatesettlerequest');

    

    

    
 
});

// Route::get('/home', 'HomeController@index')->name('home');

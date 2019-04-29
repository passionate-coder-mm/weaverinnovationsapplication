<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Userdepartment;
use App\User;
use App\Leave;
use App\Notification;
use App\Notifications\NotifyToManager;
use DatePeriod;
use DateTime;
use DateInterval;
use App\Preattendance;
use App\Billnotification;
use App\Attendance;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        if(Auth::check()){
        $user_id  = Auth::user()->id;
        $findAttendanceid = Preattendance::where('user_id',$user_id)->first();
        if($findAttendanceid){
            $att_id = $findAttendanceid->attendance_id;
        }else{
            $att_id = 0;
        }
        $first_day_of_currant_year = date('m/d/Y', strtotime('first day of january this year'));
        $last_day_of_currant_year = date('m/d/Y', strtotime('last day of december this year'));
        $data=[];
        $data['annualLeave']= DB::table('leaves')->where('user_id',$user_id)->where('annual_leave','=','yes')->whereBetween('date',[$first_day_of_currant_year,$last_day_of_currant_year])->count('id');
        $data['sickLeave']= DB::table('leaves')->where('user_id',$user_id)->where('sick_leave','=','yes')->whereBetween('date',[$first_day_of_currant_year,$last_day_of_currant_year])->count('id');
        $data['lateEntry']= DB::table('attendances')->where('attendance_id',$att_id)->where('late_entry','=','yes')->whereBetween('att_date',[$first_day_of_currant_year,$last_day_of_currant_year])->count('id');
        $data['earlyLeave']= DB::table('attendances')->where('attendance_id',$att_id)->where('early_leave','=','yes')->whereBetween('att_date',[$first_day_of_currant_year,$last_day_of_currant_year])->count('id');
        $data['lateApproval']= DB::table('leaves')->where('user_id', $user_id)->where('leaveapproval','=','yes')->whereBetween('date',[$first_day_of_currant_year,$last_day_of_currant_year])->count('id');
        $data['transportbill'] = Billnotification::where('notifiable_id',0)->where('read_at','=','no')->get();

        return view('Backend.admindashboard',compact('data'));
        }
        
    }
    public function showProfile(User $slug){
       return view('Backend.User.profile',compact('slug'));
    }
    public function waitingforvarification(){
        // return view('Backend.userdashboard');
    }
}

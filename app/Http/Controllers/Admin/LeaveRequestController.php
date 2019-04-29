<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Userdepartment;
use App\User;
use App\Leave;
use App\Notification;
use App\Notifications\NotifyToManager;
use DatePeriod;
use DateTime;
use DateInterval;
use App\Preattendance;
use App\Attendance;
use DB;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        if(Auth::check()){
           $user_id = Auth::user()->id;
        }else{
            return redirect('/login');
        }
       $find_login_user_dept_id = Userdepartment::where('user_id',$user_id )->first();
       if(!empty($find_login_user_dept_id)){
        $find_login_user_dept_mng = DB::table('users')
                                    ->leftjoin('userdepartments','users.id','=','userdepartments.user_id')
                                    ->select('users.id','users.name')
                                    ->where('userdepartments.department_id',$find_login_user_dept_id->department_id)
                                    ->where('users.role',3)
                                    ->first();
       }
       
     $all_request_by_id =DB::table('users')
                         ->leftJoin('leaves','users.id','=','leaves.user_id')
                         ->select('leaves.*','users.name')
                         ->where('leaves.user_id',$user_id)
                         ->groupBy('leaves.uniqueidentification') 
                         ->get();
    $manager_notifications = DB::table('users')
                            ->leftJoin('leaves','users.id','=','leaves.user_id')
                            ->select('leaves.*','users.name')
                            ->where('leaves.receiver',$user_id)
                            ->groupBy('leaves.uniqueidentification') 
                            ->get();

        return view('Backend.Leave.leave_requestform',compact('find_login_user_dept_mng','all_request_by_id','manager_notifications'));
    }
    public function checkleaverequestdate($leavedate,$userid){
     $exlodedate = explode('-',$leavedate);
     $orginal_date =$exlodedate[0].'/'.$exlodedate[1].'/'.$exlodedate[2]; 
     $find_user_attid = Preattendance::where('user_id',$userid)->first();
     if(!empty($find_user_attid)){
        $find_user_attendance = Attendance::where('attendance_id','=',$find_user_attid->attendance_id)->where('att_date','=',$orginal_date)->first();
     }
     $get_all_holiday = DB::table('governmentholidays')->select('date')->get()->toArray();
     foreach($get_all_holiday as $value){
        $final_list[] = $value->date; 
    }
    if (in_array($orginal_date, $final_list)){
        return response()->json ('Match');
    }else if($find_user_attendance ==''){   
         return response()->json('Absent');
    }else{
        $in_time = $find_user_attendance->in_time;
        $explodeintime = explode(':', $in_time);
        $new_intime =$explodeintime[0].':'.$explodeintime[1];
        $exact_intime= strtotime($new_intime);

        $out_time = $find_user_attendance->out_time;
        $explodeouttime = explode(':', $out_time);
        $new_outtime =$explodeouttime[0].':'.$explodeouttime[1];
        $exact_outtime= strtotime($new_outtime);
        $ideal_inntime =strtotime('09:00');
        $ideal_outtime =strtotime('06:00');
        if($exact_intime <= $ideal_inntime && $exact_outtime >= $ideal_outtime){
            return response()->json('Intime');
        }else{
            return response()->json('Request');
        }
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$data = $request->all();
        if($request->type =="latecome/earlyleave"){
            $unqid = uniqid();
            $find_user_attid = Preattendance::where('user_id',$request->user_id)->first();
            $leave = new Leave();
            if(!empty($find_user_attid)){
                $leave->attendance_id = $find_user_attid->attendance_id;
               }
            $leave->purpose = $request->type;
            $leave->user_id = $request->user_id;
            $leave->date = $request->laeadate;
            $leave->uniqueidentification = $unqid;
            $leave->cause = $request->cause;
            $leave->receiver = $request->manager_id;
            $leave->save();
            $find_dept_manager = User::find($request->manager_id);
            $find_dept_manager->notify(new NotifyToManager($leave));
            $all_request_by_id =DB::table('users')
                                ->leftJoin('leaves','users.id','=','leaves.user_id')
                                ->select('leaves.*','users.name')
                                ->where('leaves.uniqueidentification',$unqid)
                                ->first();
           return response()->json($all_request_by_id);
        }else{
        $begin = new DateTime($request->from_date);
        $end = new DateTime($request->to_date);
        $end = $end->modify( '+1 day' ); 
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        $gov_holiday_list = DB::table('governmentholidays')->select('date')->get()->toArray(); 
        
        foreach($gov_holiday_list as $value){
            $final_list[] = $value->date; 
        }
        foreach($daterange as $alldate){
            if(date('D', strtotime($alldate->format('m/d/Y')))!='Fri'){
                $allarray[] = $alldate->format('m/d/Y');
            }
        }
        $result = array_intersect($allarray,$final_list);
            if(count($result) > 0){
                $total_absent = array_diff($allarray,$result);
            }else{
                $total_absent = $allarray;
            }
            
            $find_user_attid = Preattendance::where('user_id',$request->user_id)->first();
            $previousmonth = date('m/d/Y', strtotime('first day of last month'));
            $nextmonth = date('m/d/Y', strtotime('first day of +2 month'));
            $find_user_allattendance = DB::table('attendances')->where('attendance_id',$find_user_attid->attendance_id)->whereBetween('att_date',[$previousmonth,$nextmonth])->select('att_date')->get()->toArray();
            if($find_user_allattendance){
                foreach($find_user_allattendance as $attlist){
                   $attendance_list[] = $attlist->att_date;
                }
                $no_of_request = array_intersect($total_absent,$attendance_list);
            }
            if(count($no_of_request) > 0){
                $my_total_absent = array_diff($total_absent,$no_of_request);
            }else{
                $my_total_absent = $total_absent;
            }
           
            if(count($my_total_absent) > 0){
                $unqid = uniqid();
                foreach($my_total_absent as $total_ab){
                    $leave = new Leave();
                        $leave->purpose = $request->type;
                        $leave->date = $total_ab;
                        $leave->user_id = $request->user_id;
                        if(!empty($find_user_attid)){
                         $leave->attendance_id = $find_user_attid->attendance_id;
                        }
                        $leave->uniqueidentification = $unqid;
                        $leave->cause = $request->cause;
                        $leave->receiver = $request->manager_id;
                        $leave->save();
                    
                }
                
                $find_dept_manager = User::find($request->manager_id);
                $find_dept_manager->notify(new NotifyToManager($leave));
                $all_request_by_id =DB::table('users')
                             ->leftJoin('leaves','users.id','=','leaves.user_id')
                             ->select('leaves.*','users.name')
                             ->where('leaves.uniqueidentification',$unqid)
                             ->first();
                
                return response()->json($all_request_by_id);
            }else{
                return response()->json('Error');
            }
            
        }
       
    }

    public function getallNotifications(){
        $notifications = Auth::user()->unreadNotifications;
        return $notifications; 
    }
    public function read(Request $request){
        Auth::user()->unreadNotifications()->find($request->id)->markasRead();
        return "success";
    }
    public function approvalblade($id,$uniqueidentification){
        $request_chk_id = leave::find($id);
        if($id == $request_chk_id->id && $uniqueidentification == $request_chk_id->uniqueidentification){
            $request_user_id = leave::find($id);
            $find_name = User::find($request_user_id->user_id);
            $request = Leave::where('uniqueidentification',$uniqueidentification)->pluck('date')->toArray();
            // foreach($request as $rqdate){
            //     $requestdate[]= $rqdate->date;
            // }
            return view('Backend.Leave.approve_leave',compact('find_name','request_user_id','request'));
        } else{
            return redirect()->route('leave_options.index');
        }
        
    }
    public function leaveorlateapproval(Request $request){
        if($request->type =="latecome/earlyleave"){
          $find_leave = Leave::where('uniqueidentification',$request->uniqueidentification)->first();
          $find_leave->lateearlyapprove="yes";
          $find_leave->save();     
         } else{
             if($request->type =="sick leave"){
                $find_leave = Leave::where('uniqueidentification',$request->uniqueidentification)->update(['leaveapproval'=>'yes','sick_leave'=>'yes']);

             }elseif($request->type =="annual leave"){
                $find_leave = Leave::where('uniqueidentification',$request->uniqueidentification)->update(['leaveapproval'=>'yes','annual_leave'=>'yes']);

             }
         }
       return response()->json('success');
    }
    public function approvefrommng($id,$type){
        if($type =="latecomeearlyleave"){
            $find_leave = Leave::where('uniqueidentification',$id)->first();
            $find_leave->lateearlyapprove="yes";
            $find_leave->save();     
           } else{
               if($type =="sick leave"){
                  $find_leave = Leave::where('uniqueidentification',$id)->update(['leaveapproval'=>'yes','sick_leave'=>'yes']);
  
               }elseif($type =="annual leave"){
                  $find_leave = Leave::where('uniqueidentification',$id)->update(['leaveapproval'=>'yes','annual_leave'=>'yes']);
  
               }
           }
        //    $find_leave_uniq_id =  Leave::where('uniqueidentification',$id)->first();
        //    $find_notyfyable_uer = Leave::where('user_id',$find_leave_uniq_id->user_id)->first();
        //    $find_notyfyable_uer->notify(new NotifyToManager($leave));
         return response()->json('success');
    }
    public function disapprove($unq_id){
        $find_disapproval = Leave::where('uniqueidentification',$unq_id)->get();
        foreach($find_disapproval as $primaryunqid){
            $leave_disapprove = Leave::find($primaryunqid->id);
            $leave_disapprove->leaveapproval = "no";
            $leave_disapprove->save();
            //$leave_disapprove->delete();
        }
        return response()->json('success');
    }

    public function allleaverequest(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
        }
         $all_request_by_id =DB::table('users')
                             ->leftJoin('leaves','users.id','=','leaves.user_id')
                             ->select('leaves.*','users.name')
                             ->where('leaves.user_id',$user_id)
                             ->groupBy('leaves.uniqueidentification') 
                             ->get();
         return view('Backend.Leave.all_leave_request',compact('all_request_by_id'));
    }
    public function detailrequest($id,$type){
      if($type =="latecomeearlyleave"){
         $find_request = DB::table('users')
                        ->leftJoin('leaves','users.id','=','leaves.user_id')
                        ->select('leaves.*','users.name')
                        ->where('leaves.uniqueidentification',$id)
                        ->first();
         return response()->json([$find_request]);

      }else{
        $find_request_date = Leave::where('uniqueidentification',$id)->pluck('date')->toArray();
        $find_request = DB::table('users')
                        ->leftJoin('leaves','users.id','=','leaves.user_id')
                        ->select('leaves.*','users.name')
                        ->where('leaves.uniqueidentification',$id)
                        ->first();
        return response()->json([$find_request, $find_request_date]);

      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

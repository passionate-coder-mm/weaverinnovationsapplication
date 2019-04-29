<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Preattendance;
use App\User;
use App\Department;
use App\Attendance;
use App\Leave;
use DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $user_list  = User::all();
        $attendance_list = DB::table('preattendances')
                            ->leftJoin('users','users.id','=','preattendances.user_id')
                            ->leftJoin('userdepartments','userdepartments.user_id','=','users.id')
                            ->leftJoin('departments','departments.id','=','userdepartments.department_id')
                            ->select('users.id','users.name','users.image','departments.department_name','preattendances.attendance_id','preattendances.status','preattendances.id as preattid')
                            ->get();
        return view('Backend.Attendance.pre_attendance',compact('user_list','attendance_list'));
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
    public function unqattidchk(){
        $chk_existancy = Preattendance::where('attendance_id',Input::get('attendance_id'))->first();
        if($chk_existancy){
            return response()->json('Id is already taken');
        } else{
            return response()->json('true');
        }
    }
    public function unquserchk($user_id){
        $chk_existancy = Preattendance::where('user_id',$user_id)->first();
        if(!empty($chk_existancy)){
            return response()->json('true');
        }else{
            return response()->json('false');
        }
    }
    
    public function store(Request $request)
    {   
        $pre_attendance_data = new Preattendance();
        $pre_attendance_data->user_id = $request->user_id;
        $pre_attendance_data->attendance_id = $request->attendance_id;
        $pre_attendance_data->save();
        $user_info = DB::table('preattendances')
                    ->leftJoin('users','users.id','=','preattendances.user_id')
                    ->leftJoin('userdepartments','userdepartments.user_id','=','users.id')
                    ->leftJoin('departments','departments.id','=','userdepartments.department_id')
                    ->select('users.id as userid','users.name','users.image','departments.department_name','preattendances.attendance_id','preattendances.status','preattendances.id as preattid')
                    ->where('users.id','=',$request->user_id)
                    ->first();
       

        return response()->json($user_info);
                   
    }

    public function userdailyattendance(Request  $request, $attendanceid, $inorout){
        if($inorout == 1){
            $get_user_id = Preattendance::where('attendance_id','=',$attendanceid)->first();
            if(!empty($get_user_id)){
                $pretable_id = $get_user_id->id;
                $date = date("m/d/Y");
                $get_existance_user_by_attendanceid = Attendance::where('attendance_id','=',$attendanceid)->where('att_date','=',$date)->first();
                if(!empty($get_existance_user_by_attendanceid)){
                    return "Your entrance has been already registered for today";
                } else {
                    $time = date("h:i:a");
                    $date = date("m/d/Y");
                    $daily_attendance = new Attendance();
                    $daily_attendance->attendance_id = $attendanceid;
                    $daily_attendance->in_time = $time;
                    $daily_attendance->att_date = $date;
                    $daily_attendance->preattendance_id = $pretable_id;
                    $daily_attendance->save();
                    return "Your entrance has been registered";
                }
            } else {
                return "Invalid status";
            }
        } elseif($inorout == 0){
                    // $get_user_id = Preattendance::where('attendance_id','=',$attendanceid)->first();
                    $date = date("m/d/Y");
                    $time = date("h:i:a");
                    $get_existance_user_by_attendanceid = Attendance::where('attendance_id','=',$attendanceid)->where('att_date','=',$date)->first();
                    if(!empty($get_existance_user_by_attendanceid) && $get_existance_user_by_attendanceid->out_time == 0){
                        $find_in_user_by_id_date = Attendance::where('attendance_id','=',$attendanceid)->where('att_date','=',$date)->first();
                        $find_in_user_by_id_date->out_time = $time; 
                        $find_in_user_by_id_date->save();
                        return " You have  signed out for today";
                    } elseif(!empty($get_existance_user_by_attendanceid) && $get_existance_user_by_attendanceid->out_time != 0) {
                             return "Sorry You have already signed out for today";
                    } else {
                        return "Invalid status";
                    }  
         } else {
             return "Invalid status";
         }
            
    }
    public function activedeactiveoption($id,$teamid){
        $find_att_id = Preattendance::where('id','=',$teamid)->first();
        $find_att_id->status = $id;
        $find_att_id->save();
       return response()->json($find_att_id);
    }

    public function showattendancefilter(){
        $all_user = User::all();
        return view('Backend.Attendance.attendancefilter',compact('all_user'));
    }

    public function datewiseappendance(Request $request){
        $user_id = $request->user_id;
        $to_date = $request->to_date;
        $from_date = $request->from_date;
        $date_wise_attendance = DB::table('attendances')
                                ->leftJoin('preattendances','attendances.preattendance_id','=','preattendances.id')
                                ->leftJoin('users','users.id','=','preattendances.user_id')
                                ->select('users.name','preattendances.status','attendances.in_time','attendances.out_time','attendances.att_date')
                                ->whereBetween('attendances.att_date', [$from_date, $to_date])
                                ->where('preattendances.user_id','=',$user_id)
                                ->get();
        $gov_holiday_list = DB::table('governmentholidays')->select('date')->get();
        $final_list = array( );
        $i = 0;
        foreach( $gov_holiday_list as $value){
            $i++;
            $final_list[$i] = $value->date; 
        }
        $late_approve_count = DB::table('leaves')->where('user_id',$user_id)->where('lateearlyapprove','=','yes')->whereBetween('date',[$from_date, $to_date])->count('id');
        $annual_leave_count = DB::table('leaves')->where('user_id',$user_id)->where('annual_leave','=','yes')->whereBetween('date',[$from_date, $to_date])->count('id');
        $sick_leave_count = DB::table('leaves')->where('user_id',$user_id)->where('sick_leave','=','yes')->whereBetween('date',[$from_date, $to_date])->count('id');

        return response()->json([$date_wise_attendance,$final_list,$late_approve_count,$annual_leave_count,$sick_leave_count]);
    }
    public function showallattendancehistory(){
        return view('Backend.Attendance.all_employee_attendance_summary');
    }
    public function datewiseallemployeeattendance(Request $request){
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        // $employee_attendance_summary = DB::select(DB::raw('SELECT t1.preattendance_id,t1.attendance_id,t2.late_entry,t2.early_leave, COUNT(t1.id) AS totalattend, COUNT(t2.late_entry) AS lateentry,COUNT(t2.early_leave) AS earlyleave FROM attendances t1 , attendances t2  WHERE t1.id = t2.id GROUP BY t1.attendance_id'));
        $employee_attendance_summary = DB::select(DB::raw("SELECT users.name, preattendances.user_id, attendances.preattendance_id,attendances.attendance_id,attendances.late_entry,attendances.early_leave, COUNT(attendances.id) AS totalattend,COUNT(attendances.late_entry) AS lateentry,COUNT(attendances.early_leave) AS earlyleave   FROM attendances LEFT JOIN preattendances ON attendances.preattendance_id = preattendances.id LEFT JOIN users ON users.id = preattendances.user_id WHERE attendances.att_date BETWEEN '$from_date' AND '$to_date' GROUP BY attendance_id"));
        $leave_count = DB::select(DB::raw("SELECT user_id, COUNT(annual_leave) AS annualleave,COUNT(sick_leave)AS sickleave FROM LEAVES WHERE date BETWEEN '04/01/2019' AND '04/04/2019' GROUP BY attendance_id"));  
         $neqArray =[];
         $i=0;
         foreach($employee_attendance_summary as $summary){
            $i++;
            $count_annualleave = Leave::where('user_id',$summary->user_id)->where('annual_leave','=','yes')->whereBetween('date',[$from_date, $to_date])->get();
            $count_sickleave = Leave::where('user_id',$summary->user_id)->where('sick_leave','=','yes')->whereBetween('date',[$from_date, $to_date])->get();
            $count_laea_approve = Leave::where('user_id',$summary->user_id)->where('lateearlyapprove','=','yes')->whereBetween('date',[$from_date, $to_date])->get();
            if($count_laea_approve){
                $number_of_laea_approval = count($count_laea_approve);
            }else{
                $number_of_laea_approval = 0;
            }
            if($count_annualleave){
                $number_of_sick_leave = count($count_sickleave);
            }else{
                $number_of_sick_leave = 0;
            }
            if($count_annualleave){
                $numberof_leave = count($count_annualleave);
            }else{
                $numberof_leave = 0; 
            }
            $neqArray[$i]['name'] = $summary->name;
            $neqArray[$i]['latecount'] = $summary->lateentry;
            $neqArray[$i]['earlyleave'] = $summary->earlyleave;
            $neqArray[$i]['totalattend'] = $summary->totalattend;
            $neqArray[$i]['annualleave']=  $numberof_leave;
            $neqArray[$i]['sickleave']=  $number_of_sick_leave;
            $neqArray[$i]['lateapprove']=  $number_of_laea_approval;
        }
        $gov_holiday_list = DB::table('governmentholidays')->select('date')->get();
        $final_list = array( );
        $i = 0;
        foreach( $gov_holiday_list as $value){
            $i++;
            $final_list[$i] = $value->date; 
        }
        return response()->json([$neqArray,$final_list]); 

    
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

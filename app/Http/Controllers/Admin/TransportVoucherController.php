<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ConveyanceVoucher;
use App\Billnotification;
use App\Userdepartment;
use DateTime;
use DateTimeZone;
use App\User;
use DB;
use Auth;

class TransportVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = [];
       $data['executive_con'] = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.review,conveyance_vouchers.created_at,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                                    FROM conveyance_vouchers
                                    LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                    WHERE users.role = 5
                                    GROUP BY(conveyance_vouchers.unq_id)"));
        $data['manager_con'] = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.created_at,conveyance_vouchers.review,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                                    FROM conveyance_vouchers
                                    LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                    WHERE users.role = 3
                                    GROUP BY(conveyance_vouchers.unq_id)"));
        $data['assmanager_con'] = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.created_at,conveyance_vouchers.review,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                                    FROM conveyance_vouchers
                                    LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                    WHERE users.role = 4
                                    GROUP BY(conveyance_vouchers.unq_id)"));
         $data['ceo_con'] = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.review,conveyance_vouchers.created_at,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                                    FROM conveyance_vouchers
                                    LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                    WHERE users.role = 6
                                    GROUP BY(conveyance_vouchers.unq_id)"));
         $data['cfo_con'] = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.created_at,conveyance_vouchers.review,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                                     FROM conveyance_vouchers
                                     LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                                     WHERE users.role = 7
                                     GROUP BY(conveyance_vouchers.unq_id)"));
        return view('Backend.Vas.transport_voucher',compact('data'));
    }
    public function makemessagecountZero($id,$userrole){
        if($userrole==3){
            $find_notification = Billnotification::where('notifiable_id',$id)->update(['read_at'=>'yes']);
        }elseif($userrole == 6){
            $find_notification = Billnotification::where('notifiable_id',$id)->update(['read_at'=>'no']);
        }elseif($userrole == 7){
            $find_notification = Billnotification::where('notifiable_id',$id)->update(['read_at'=>'no']);
        }
        elseif($userrole==8){
            $find_notification = Billnotification::where('notifiable_id',0)->update(['read_at'=>'complete']);
        }
        return response()->json($find_notification);
    }
    public function getallbillinfobyId($id){
      $allBillinfo = ConveyanceVoucher::where('unq_id',$id)->get();
      return response()->json($allBillinfo);
    }
    public function showsingledetailbill($id){
        $find_single_bill = ConveyanceVoucher::where('unq_id',$id)->get();
        $first_item = ConveyanceVoucher::where('unq_id',$id)->first();
        return view('Backend.Vas.single_bill',compact('find_single_bill','first_item'));
    }
    public function approveconveyanceBysuperior($id,$notifiable,$role){
        $find_ceo = User::where('role','=',6)->first();
        $find_cfo = User::where('role','=',7)->first();
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $time= $dt->format('m-d-Y, H:i:s');
        if($role==3){
            $find_to_approve = ConveyanceVoucher::where('unq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'approvedby_manager'=>$notifiable,'status'=>'CEO','read_at'=>'no','managerapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'read_at'=>'ceono']);
       }elseif($role==6){
            $find_to_approve = ConveyanceVoucher::where('unq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'approvedby_ceo'=>$notifiable,'status'=>'CFO','read_at'=>'no','ceoapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'read_at'=>'cfono']);

       }elseif($role==7){
        $find_to_approve = ConveyanceVoucher::where('unq_id',$id)->update(['notifiable_id'=>'0','approvedby_cfo'=>$notifiable,'status'=>'ACC','read_at'=>'no','cfoapprove_date'=>$time]);
        $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>'0','read_at'=>'no']);

       }
        return response()->json('success');
    }
    public function reviewit($unqid){
        $send_for_review = ConveyanceVoucher::where('unq_id',$unqid)->update(['review'=>'yes']);
        return response()->json('success');
    }
    public function allpaybleTransportbill(){
        $payableBilllist = DB::select(DB::raw("SELECT conveyance_vouchers.id,conveyance_vouchers.created_at,conveyance_vouchers.user_id,conveyance_vouchers.unq_id,conveyance_vouchers.designation_name,conveyance_vouchers.status,conveyance_vouchers.project_name,users.role,SUM(conveyance_vouchers.amount) AS total
                            FROM conveyance_vouchers
                            LEFT JOIN users ON conveyance_vouchers.user_id = users.id
                            WHERE conveyance_vouchers.notifiable_id = 0
                            GROUP BY(conveyance_vouchers.unq_id)"));
        return view('Backend.Vas.payabletransportbill',compact('payableBilllist'));
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
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user_role= Auth::user()->role;
         }else{
             return redirect('/login');
         }
         $unique_id = uniqid();
         $find_login_user_dept_id = Userdepartment::where('user_id',$user_id )->first();
        if(!empty($find_login_user_dept_id)){
         $find_login_user_dept_mng = DB::table('users')
                                     ->leftjoin('userdepartments','users.id','=','userdepartments.user_id')
                                     ->select('users.id','users.name')
                                     ->where('userdepartments.department_id',$find_login_user_dept_id->department_id)
                                     ->where('users.role',3)
                                     ->first();
        }
        
        switch ($user_role) {
            case 5:
                $notifiableid = $find_login_user_dept_mng->id;
                $status = "Manager";
                break;
            case 4:
               $notifiableid = $find_login_user_dept_mng->id;
               $status = "Manager";
                break;
            case 3:
                $find_ceo = User::where('role','=',6)->first();
                $notifiableid = $find_ceo->id;
                $status = "CEO";
                break;
            case 6:
                $find_cfo = User::where('role','=',7)->first();
                $notifiableid = $find_cfo->id;
                $status = "CFO";
                break;
            case 7:
                $notifiableid = 0;
                $status = "ACC";
                break;
            default:
            echo "none of these";
        }
        if($user_role !=7){
            $notfication = new Billnotification();
            $projectname = $request->project_name != null ? $request->project_name : "General";  
            $notfication->notifiable_type = $projectname;
            $notfication->notifiable_id = $notifiableid ;
            $notfication->read_at = 'no' ;
            $notfication->unq_id = $unique_id;
            $notfication->save();
        }
        $data=[];
        $get_user_designation =DB::table('userdesignations')
                               ->leftJoin('designations','userdesignations.designation_id','=','designations.id')
                               ->select('designations.designation_name') 
                               ->where('userdesignations.user_id',$request->user_id)
                               ->first();
       
        if( $get_user_designation){
            $designation_name = $get_user_designation->designation_name;
        }else{
            $designation_name = "N/A";
        }
        if($request->project_name !=null){
            $total = 0;
            foreach($request->program as $cost){
                $conveyance = new ConveyanceVoucher();
                $conveyance->user_id = $request->user_id;
                $conveyance->designation_name = $designation_name;
                $conveyance->project_name = $request->project_name;
                $conveyance->date = $cost['date'];
                $conveyance->from =  $cost['from'];
                $conveyance->to =  $cost['to'];
                $conveyance->mode =  $cost['mode'];
                $conveyance->purpose =  $cost['purpose'];
                $conveyance->amount =  $cost['amount'];
                $conveyance->unq_id =  $unique_id;
                $conveyance->status =   $status;
                $conveyance->notifiable_id = $notifiableid;
                $conveyance->read_at = 'no';
               
                $conveyance->save();
                $total += $cost['amount'];
            }
            $data['submited_date'] = date("m/d/Y h:i:s A");
            $data['total'] = $total;
            $data['conveyance'] = $conveyance;
            return response()->json($data);
        }else{
            $total = 0;
            
            foreach($request->program as $cost){
                $conveyance = new ConveyanceVoucher();
                $conveyance->user_id = $request->user_id;
                $conveyance->designation_name = $designation_name;
                $conveyance->date = $cost['date'];
                $conveyance->from =  $cost['from'];
                $conveyance->to =  $cost['to'];
                $conveyance->mode =  $cost['mode'];
                $conveyance->purpose =  $cost['purpose'];
                $conveyance->amount =  $cost['amount'];
                $conveyance->unq_id =  $unique_id;
                $conveyance->status =  $status;
                $conveyance->notifiable_id = $notifiableid;
                $conveyance->read_at = 'no';
                $conveyance->project_name = "General";
                $conveyance->save();
                $total += $cost['amount'];
        }
           $data['submited_date'] = date("m-d-Y h:i:s A");
            $data['total'] = $total;
            $data['conveyance'] = $conveyance;
          return response()->json($data);
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
    public function update(Request $request)
    {   
        $delete_bill_notification = Billnotification::where('unq_id',$request->unq_id)->first();
        $bill_noti = Billnotification::find($delete_bill_notification->id);
        $bill_noti->delete();
        $delete_conveyence = ConveyanceVoucher::where('unq_id',$request->unq_id)->get();
        foreach($delete_conveyence as $value){
            $conveyance_noti = ConveyanceVoucher::find($value->id);
            $conveyance_noti->delete();
  
        }
        $unique_id = uniqid();
        $find_login_user_dept_id = Userdepartment::where('user_id',$request->user_id)->first();
        $find_login_user_role_id = User::where('id',$request->user_id)->first();
        $user_role = $find_login_user_role_id->role;
       if(!empty($find_login_user_dept_id)){
        $find_login_user_dept_mng = DB::table('users')
                                    ->leftjoin('userdepartments','users.id','=','userdepartments.user_id')
                                    ->select('users.id','users.name')
                                    ->where('userdepartments.department_id',$find_login_user_dept_id->department_id)
                                    ->where('users.role',3)
                                    ->first();
       }
       
       switch ($user_role) {
           case 5:
               $notifiableid = $find_login_user_dept_mng->id;
               $status = "Manager";
               break;
           case 4:
              $notifiableid = $find_login_user_dept_mng->id;
              $status = "Manager";
               break;
           case 3:
               $find_ceo = User::where('role','=',6)->first();
               $notifiableid = $find_ceo->id;
               $status = "CEO";
               break;
           case 6:
               $find_cfo = User::where('role','=',7)->first();
               $notifiableid = $find_cfo->id;
               $status = "CFO";
               break;
           case 7:
               $notifiableid = 0;
               $status = "ACC";
               break;
           default:
           echo "none of these";
       }
       if($user_role !=7){
        $notfication = new Billnotification();
        $projectname = $request->project_name;  
        $notfication->notifiable_type = $projectname;
        $notfication->notifiable_id = $notifiableid ;
        $notfication->read_at = 'no' ;
        $notfication->unq_id = $unique_id;
        $notfication->save();
    }
    $total = 0;
    foreach($request->program as $cost){
        $conveyance = new ConveyanceVoucher();
        $conveyance->user_id = $request->user_id;
        $conveyance->designation_name = $request->designation_name;
        $conveyance->date = $cost['date'];
        $conveyance->from =  $cost['from'];
        $conveyance->to =  $cost['to'];
        $conveyance->mode =  $cost['mode'];
        $conveyance->purpose =  $cost['purpose'];
        $conveyance->amount =  $cost['amount'];
        $conveyance->unq_id =  $unique_id;
        $conveyance->status =  $status;
        $conveyance->notifiable_id = $notifiableid;
        $conveyance->read_at = 'no';
        $conveyance->review = 'reviwed';
        $conveyance->project_name = $request->project_name;
        $conveyance->save();
        $total += $cost['amount'];
        
    }
    $data['submited_date'] = date("m-d-Y h:i:s A");
            $data['total'] = $total;
            $data['conveyance'] = $conveyance;
          return response()->json($data);
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

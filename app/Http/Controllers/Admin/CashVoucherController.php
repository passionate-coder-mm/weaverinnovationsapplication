<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\projectname;
use App\Cashvoucher;
use App\Billnotification;
use App\Userdepartment;
use App\Expenseadvance;
use DateTime;
use DateTimeZone;
use App\User;
use DB;
use Auth;

class CashVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $data=[];
        $data['for_executive'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 5 And cashvouchers.type ='Advance' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_executive_ad_succeed']= DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                            FROM cashvouchers
                                            LEFT JOIN users ON cashvouchers.user_id = users.id
                                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                            WHERE users.role = 5 And cashvouchers.type ='Advance' And cashvouchers.success ='yes'
                                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_executive_ad_expenses'] = DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.review,expenseadvances.type,expenseadvances.advance_amount,expenseadvances.created_at,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,SUM(expenseadvances.advance_expense) AS totalexpense,projectnames.id AS projectid,users.role
                                            FROM expenseadvances
                                            LEFT JOIN users ON expenseadvances.user_id = users.id
                                            LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                            WHERE users.role = 5 AND expenseadvances.type ='advanceexpense' 
                                            GROUP BY(expenseadvances.anotherunq_id)"));
        $data['for_executive_expense'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                FROM cashvouchers
                                LEFT JOIN users ON cashvouchers.user_id = users.id
                                LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                WHERE users.role = 5 And cashvouchers.type ='Expense' And cashvouchers.success ='no'
                                GROUP BY(cashvouchers.unq_id)"));
        $data['for_executive_exp_succeed'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                FROM cashvouchers
                                LEFT JOIN users ON cashvouchers.user_id = users.id
                                LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                WHERE users.role = 5 And cashvouchers.type ='Expense' And cashvouchers.success ='yes'
                                GROUP BY(cashvouchers.unq_id)"));
         $data['for_assmng'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 4 And cashvouchers.type ='Advance' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
         $data['for_assmng_ad_succeed']= DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                        FROM cashvouchers
                                        LEFT JOIN users ON cashvouchers.user_id = users.id
                                        LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                        WHERE users.role = 4 And cashvouchers.type ='Advance' And cashvouchers.success ='yes'
                                        GROUP BY(cashvouchers.unq_id)"));
         $data['for_assmng_ad_expenses'] = DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.review,expenseadvances.type,expenseadvances.advance_amount,expenseadvances.created_at,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,SUM(expenseadvances.advance_expense) AS totalexpense,projectnames.id AS projectid,users.role
                                            FROM expenseadvances
                                            LEFT JOIN users ON expenseadvances.user_id = users.id
                                            LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                            WHERE users.role = 4 AND expenseadvances.type ='advanceexpense' 
                                            GROUP BY(expenseadvances.anotherunq_id)"));
        $data['for_assmng_expense'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 4 And cashvouchers.type ='Expense' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_assmng_exp_succeed'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                             FROM cashvouchers
                             LEFT JOIN users ON cashvouchers.user_id = users.id
                             LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                             WHERE users.role = 4 And cashvouchers.type ='Expense' And cashvouchers.success ='yes'
                             GROUP BY(cashvouchers.unq_id)"));
        $data['for_manager'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 3 And cashvouchers.type ='Advance' And cashvouchers.success ='no' 
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_manager_ad_succeed']= DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                        FROM cashvouchers
                                        LEFT JOIN users ON cashvouchers.user_id = users.id
                                        LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                        WHERE users.role = 3 And cashvouchers.type ='Advance' And cashvouchers.success ='yes'
                                        GROUP BY(cashvouchers.unq_id)"));
        $data['for_manager_ad_expenses'] = DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.review,expenseadvances.type,expenseadvances.advance_amount,expenseadvances.created_at,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,SUM(expenseadvances.advance_expense) AS totalexpense,projectnames.id AS projectid,users.role
                                        FROM expenseadvances
                                        LEFT JOIN users ON expenseadvances.user_id = users.id
                                        LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                        WHERE users.role = 3 AND expenseadvances.type ='advanceexpense' 
                                        GROUP BY(expenseadvances.anotherunq_id)"));
        $data['for_manager_expense'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 3 And cashvouchers.type ='Expense' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_manager_exp_succeed'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 3 And cashvouchers.type ='Expense' And cashvouchers.success ='yes'
                            GROUP BY(cashvouchers.unq_id)"));
        
        $data['for_ceo'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 6 And cashvouchers.type ='Advance' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_ceo_ad_succeed']= DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                        FROM cashvouchers
                                        LEFT JOIN users ON cashvouchers.user_id = users.id
                                        LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                        WHERE users.role = 6 And cashvouchers.type ='Advance' And cashvouchers.success ='yes'
                                        GROUP BY(cashvouchers.unq_id)"));
         $data['for_ceo_ad_expenses'] = DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.review,expenseadvances.type,expenseadvances.advance_amount,expenseadvances.created_at,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,SUM(expenseadvances.advance_expense) AS totalexpense,projectnames.id AS projectid,users.role
                                        FROM expenseadvances
                                        LEFT JOIN users ON expenseadvances.user_id = users.id
                                        LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                        WHERE users.role = 6 AND expenseadvances.type ='advanceexpense' 
                                        GROUP BY(expenseadvances.anotherunq_id)"));
        $data['for_ceo_expense'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 6 And cashvouchers.type ='Expense' And cashvouchers.success ='no' 
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_ceo_exp_succeed'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 6 And cashvouchers.type ='Expense' And cashvouchers.success ='yes'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_cfo'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 7 And cashvouchers.type ='Advance' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_cfo_ad_succeed']= DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                                        FROM cashvouchers
                                        LEFT JOIN users ON cashvouchers.user_id = users.id
                                        LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                        WHERE users.role = 7 And cashvouchers.type ='Advance' And cashvouchers.success ='yes'
                                        GROUP BY(cashvouchers.unq_id)"));
        $data['for_cfo_ad_expenses'] = DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.review,expenseadvances.type,expenseadvances.advance_amount,expenseadvances.created_at,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,SUM(expenseadvances.advance_expense) AS totalexpense,projectnames.id AS projectid,users.role
                                        FROM expenseadvances
                                        LEFT JOIN users ON expenseadvances.user_id = users.id
                                        LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                        WHERE users.role = 7 AND expenseadvances.type ='advanceexpense' 
                                        GROUP BY(expenseadvances.anotherunq_id)"));
        $data['for_cfo_expense'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 7 And cashvouchers.type ='Expense' And cashvouchers.success ='no'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['for_cfo_exp_succeed'] = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.review,cashvouchers.type,cashvouchers.created_at,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.designation_name,cashvouchers.status,projectnames.project_name,projectnames.id as projectid,users.role,SUM(cashvouchers.amount) AS total
                            FROM cashvouchers
                            LEFT JOIN users ON cashvouchers.user_id = users.id
                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                            WHERE users.role = 7 And cashvouchers.type ='Expense' And cashvouchers.success ='yes'
                            GROUP BY(cashvouchers.unq_id)"));
        $data['project-name'] = projectname::all();
        return view('Backend.Vas.cash_voucher',compact('data'));
    }

    public function showsingledetailcashbill($unqid){
        $find_single_cashbill =  DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.date,cashvouchers.description,cashvouchers.amount,cashvouchers.review,cashvouchers.type,cashvouchers.user_id,cashvouchers.unq_id,cashvouchers.status,projectnames.project_name,users.role,users.name
                                FROM cashvouchers
                                LEFT JOIN users ON cashvouchers.user_id = users.id
                                LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                WHERE cashvouchers.unq_id = :unq_id"),array('unq_id' => $unqid)); 
         $first_item = Cashvoucher::where('unq_id',$unqid)->first();
        return view('Backend.Vas.single_cashbill',compact('find_single_cashbill','first_item'));
    }
    public function settlerequestdata($unq_id){
        $find_advancebill_by_id = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.created_at,cashvouchers.type,cashvouchers.unq_id,projectnames.id AS projectid,projectnames.project_name,users.id AS userid,users.role,SUM(cashvouchers.amount) AS total
                                            FROM cashvouchers
                                            LEFT JOIN users ON cashvouchers.user_id = users.id
                                            LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                                            WHERE cashvouchers.unq_id = :unq_id"),array('unq_id' => $unq_id)); 
        return response()->json($find_advancebill_by_id);
    }
    public function sendsettleRequest(Request $request){
        //return ($request->all());
        $unique_id = uniqid();
         $find_login_user_dept_id = Userdepartment::where('user_id',$request->user_id)->first();
         $user_role = $request->role;
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
            //$notfication = Billnotification::where('unq_id','=',$request->unq_id)->first();
            $notfication = new Billnotification();

            $notfication->notifiable_type = $request->project_id;
            $notfication->notifiable_id = $notifiableid;
            $notfication->read_at = 'no' ;
            $notfication->unq_id = $request->unq_id;
            $notfication->anotherunq_id = $unique_id;
            $notfication->save();
        }
       foreach($request->program as $expenseclaim){
            $expenseClaim = new Expenseadvance();
            $expenseClaim->date = $expenseclaim['date'];
            $expenseClaim->advance_expense = $expenseclaim['amount'];
            $expenseClaim->description =  $expenseclaim['description'];
            $expenseClaim->advanceclaim_date = $request->advanceclaim_date;
            $expenseClaim->advance_amount = $request->advance_amount;
            $expenseClaim->user_id = $request->user_id;
            $expenseClaim->unq_id = $request->unq_id;
            $expenseClaim->project_id = $request->project_id;
            $expenseClaim->status = $status;
            $expenseClaim->unq_id = $request->unq_id;
            $expenseClaim->anotherunq_id = $unique_id;
            $expenseClaim->notifiable_id = $notifiableid;
            $expenseClaim->read_at = 'no';
            $expenseClaim->type = 'advanceexpense';
            $expenseClaim->save();
        }
        

      return response()->json($notfication);
    }
    public function singlecashsettle($anotherunqid){
        $find_single_advancesettle =  DB::select(DB::raw("SELECT expenseadvances.id,expenseadvances.date,expenseadvances.description,expenseadvances.advance_expense,expenseadvances.review,expenseadvances.type,expenseadvances.user_id,expenseadvances.unq_id,expenseadvances.status,projectnames.project_name,users.role,users.name
                                FROM expenseadvances
                                LEFT JOIN users ON expenseadvances.user_id = users.id
                                LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                WHERE expenseadvances.anotherunq_id = :anotherunq_id"),array('anotherunq_id' => $anotherunqid)); 
        $first_item = Expenseadvance::where('anotherunq_id',$anotherunqid)->first();
        return view('Backend.Vas.single_advancesettle',compact('find_single_advancesettle','first_item'));
    }
    public function approveadvanceSettle($id,$notifiable,$role){
        $find_ceo = User::where('role','=',6)->first();
        $find_cfo = User::where('role','=',7)->first();
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $time= $dt->format('m-d-Y, H:i:s');
        if($role==3){
            $find_to_approve = Expenseadvance::where('anotherunq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'approvedby_manager'=>$notifiable,'status'=>'CEO','read_at'=>'no','managerapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('anotherunq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'read_at'=>'ceono']);
       }elseif($role==6){
            $find_to_approve = Expenseadvance::where('anotherunq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'approvedby_ceo'=>$notifiable,'status'=>'CFO','read_at'=>'no','ceoapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('anotherunq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'read_at'=>'cfono']);

       }elseif($role==7){
        $find_to_approve = Expenseadvance::where('anotherunq_id',$id)->update(['notifiable_id'=>'0','approvedby_cfo'=>$notifiable,'status'=>'ACC','read_at'=>'no','cfoapprove_date'=>$time]);
        $find_bill_approve = Billnotification::where('anotherunq_id',$id)->update(['notifiable_id'=>'0','read_at'=>'no']);

       }
        return response()->json('success');
    }
    public function reviewexpense($unqid){
        $send_for_review = Expenseadvance::where('anotherunq_id',$unqid)->update(['review'=>'yes']);
        return response()->json('success');
    }

    public function approvecashBysuperior($id,$notifiable,$role){
        $find_ceo = User::where('role','=',6)->first();
        $find_cfo = User::where('role','=',7)->first();
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $time= $dt->format('m-d-Y, H:i:s');
        if($role==3){
            $find_to_approve = Cashvoucher::where('unq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'approvedby_manager'=>$notifiable,'status'=>'CEO','read_at'=>'no','managerapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>$find_ceo->id,'read_at'=>'ceono']);
       }elseif($role==6){
            $find_to_approve = Cashvoucher::where('unq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'approvedby_ceo'=>$notifiable,'status'=>'CFO','read_at'=>'no','ceoapprove_date'=>$time]);
            $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>$find_cfo->id,'read_at'=>'cfono']);

       }elseif($role==7){
        $find_to_approve = Cashvoucher::where('unq_id',$id)->update(['notifiable_id'=>'0','approvedby_cfo'=>$notifiable,'status'=>'ACC','read_at'=>'no','cfoapprove_date'=>$time]);
        $find_bill_approve = Billnotification::where('unq_id',$id)->update(['notifiable_id'=>'0','read_at'=>'no']);

       }
        return response()->json('success');
    }
    public function reviewit($unqid){
        $send_for_review = Cashvoucher::where('unq_id',$unqid)->update(['review'=>'yes']);
        return response()->json('success');
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
            if($request->general_chk == 'Expense'){
                $notfication->notifiable_type = $request->project_nameg;
              }else{
                $notfication->notifiable_type = $request->project_nameall;
              }
            $notfication->notifiable_id = $notifiableid ;
            $notfication->read_at = 'no' ;
            $notfication->unq_id = $unique_id;
            $notfication->save();
        }
        $data=[];
        $get_user_designation =DB::table('userdesignations')
                               ->leftJoin('designations','userdesignations.designation_id','=','designations.id')
                               ->select('designations.designation_name') 
                               ->where('userdesignations.user_id',$user_id)
                               ->first();
       
        if( $get_user_designation){
            $designation_name = $get_user_designation->designation_name;
        }else{
            $designation_name = "N/A";
        }
        if($request->general_chk == 'Expense' || $request->general_chk =='Advance'){
            $total = 0;
            foreach($request->program as $cash){
                $cashVoucher = new Cashvoucher();
                $cashVoucher->type = $request->general_chk;
                if($request->general_chk == 'Expense'){
                  $cashVoucher->project_id = $request->project_nameg;
                }else{
                    $cashVoucher->project_id = $request->project_nameall;
                }
                $cashVoucher->user_id = $user_id;
                $cashVoucher->designation_name = $designation_name;
                $cashVoucher->date = $cash['date'];
                $cashVoucher->description = $cash['description'];
                $cashVoucher->amount = $cash['amount'];
                $cashVoucher->status = $status;
                $cashVoucher->unq_id = $unique_id;
                $cashVoucher->notifiable_id = $notifiableid;
                $cashVoucher->read_at = 'no';
                $cashVoucher->save();
                $total += $cash['amount'];
            }
            $data['submited_date'] = date("m/d/Y h:i:s A");
            $data['total'] = $total;
            if($request->general_chk == 'Expense'){
                $projectname = $request->project_nameg;
            }else{
                $projectname = $request->project_nameall;
            }
            $projectname = projectname::select('project_name')->where('id',$projectname)->first();
            $data['projectname'] = $projectname->project_name;
            $data['cashvoucher'] = $cashVoucher;
            return response()->json($data);
        }else{
            return 'not done';
        }
        
    }

    public function getallcashinfo($unqid){
        $getCashinfo = DB::select(DB::raw("SELECT cashvouchers.id,cashvouchers.unq_id,cashvouchers.date,cashvouchers.type,cashvouchers.designation_name,projectnames.project_name,projectnames.id as projectid,users.name,users.id as user_id,cashvouchers.amount,cashvouchers.description
                        FROM cashvouchers
                        LEFT JOIN users ON cashvouchers.user_id = users.id
                        LEFT JOIN projectnames ON cashvouchers.project_id = projectnames.id
                        WHERE cashvouchers.unq_id = :unq_id"),array('unq_id' => $unqid)); 
        $getSettlelist = DB::select(DB::raw("SELECT expenseadvances.date,expenseadvances.advance_expense,expenseadvances.description
                                            FROM expenseadvances
                                            WHERE expenseadvances.unq_id = :unq_id"),array('unq_id' => $unqid));
                        
        return response()->json([$getCashinfo,$getSettlelist]);
    }
    public function settlelistforadvance($unqid){
        $getSettlelist = DB::select(DB::raw("SELECT expenseadvances.date,expenseadvances.advance_amount,expenseadvances.advanceclaim_date,users.role,users.id as userid,projectnames.id as projectid,expenseadvances.unq_id,expenseadvances.anotherunq_id,expenseadvances.advance_expense,expenseadvances.description
                                            FROM expenseadvances
                                            LEFT JOIN users ON expenseadvances.user_id = users.id
                                           LEFT JOIN projectnames ON expenseadvances.project_id = projectnames.id
                                            WHERE expenseadvances.unq_id = :unq_id"),array('unq_id' => $unqid));
        return response()->json($getSettlelist);

    }
    public function updatesettlerequest(Request $request){
        $find_previous_settle = Expenseadvance::where('anotherunq_id',$request->anotherunq_id)->get();
        $find_previous_settle_noti = Billnotification::where('anotherunq_id',$request->anotherunq_id)->first();
        $find_previous_settle_noti->delete();
        foreach($find_previous_settle as $ids){
            $previous_list = Expenseadvance::find($ids->id);
            $previous_list->delete();
        }
        $unique_id = uniqid();
         $find_login_user_dept_id = Userdepartment::where('user_id',$request->user_id)->first();
         $user_role = $request->role;
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
            //$notfication = Billnotification::where('unq_id','=',$request->unq_id)->first();
            $notfication = new Billnotification();

            $notfication->notifiable_type = $request->project_id;
            $notfication->notifiable_id = $notifiableid;
            $notfication->read_at = 'no' ;
            $notfication->unq_id = $request->unq_id;
            $notfication->anotherunq_id = $unique_id;
            $notfication->save();
        }
       foreach($request->program as $expenseclaim){
            $expenseClaim = new Expenseadvance();
            $expenseClaim->date = $expenseclaim['date'];
            $expenseClaim->advance_expense = $expenseclaim['advance_expense'];
            $expenseClaim->description =  $expenseclaim['description'];
            $expenseClaim->advanceclaim_date = $request->advanceclaim_date;
            $expenseClaim->advance_amount = $request->advance_amount;
            $expenseClaim->user_id = $request->user_id;
            $expenseClaim->unq_id = $request->unq_id;
            $expenseClaim->project_id = $request->project_id;
            $expenseClaim->status = $status;
            $expenseClaim->unq_id = $request->unq_id;
            $expenseClaim->anotherunq_id = $unique_id;
            $expenseClaim->notifiable_id = $notifiableid;
            $expenseClaim->read_at = 'no';
            $expenseClaim->type = 'advanceexpense';
            $expenseClaim->save();
        }
         //$data = $request->all();
        return response()->json('Success');
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
        $delete_cash = Cashvoucher::where('unq_id',$request->unq_id)->get();
        foreach($delete_cash as $value){
            $cash_noti = Cashvoucher::find($value->id);
            $cash_noti->delete();
  
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
           if($request->general_chk == 'Expense'){
               $notfication->notifiable_type = $request->project_nameg;
             }else{
               $notfication->notifiable_type = $request->project_nameall;
             }
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
       if($request->general_chk == 'Expense' || $request->general_chk =='Advance'){
           $total = 0;
           foreach($request->program as $cash){
               $cashVoucher = new Cashvoucher();
               $cashVoucher->type = $request->general_chk;
               if($request->general_chk == 'Expense'){
                 $cashVoucher->project_id = $request->project_nameg;
               }else{
                   $cashVoucher->project_id = $request->project_nameall;
               }
               $cashVoucher->user_id = $request->user_id;
               $cashVoucher->designation_name = $designation_name;
               $cashVoucher->date = $cash['date'];
               $cashVoucher->description = $cash['description'];
               $cashVoucher->amount = $cash['amount'];
               $cashVoucher->status = $status;
               $cashVoucher->unq_id = $unique_id;
               $cashVoucher->notifiable_id = $notifiableid;
               $cashVoucher->read_at = 'no';
               $cashVoucher->review = 'reviwed';
               $cashVoucher->save();
               $total += $cash['amount'];
           }
           $data['submited_date'] = date("m/d/Y h:i:s A");
           $data['total'] = $total;
           if($request->general_chk == 'Expense'){
               $projectname = $request->project_nameg;
           }else{
               $projectname = $request->project_nameall;
           }
           $projectname = projectname::select('project_name')->where('id',$projectname)->first();
           $data['projectname'] = $projectname->project_name;
           $data['cashvoucher'] = $cashVoucher;
           return response()->json($data);
       }else{
           return 'not done';
       }
        // $data = $request->all();
        // return response()->json($data);
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

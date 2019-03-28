<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Jobs\WelcomeEmailJob;
use App\Department;
use App\Role;
use App\Designation;
use App\User;
use App\Userdepartment;
use App\Userdesignation;
use DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $department_list = Department::all();
        $role_list = Role::all();
        $user_list = User::all();
        return view('Backend.User.user',compact('department_list','role_list','user_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdesigbyid($deptid){
        $get_des_by_deptid = Designation::where('department_id','=',$deptid)->get();
        $chk_dept_manager = DB::table('users')
                           ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                           ->where('userdepartments.department_id','=',$deptid)
                           ->where('users.role','=',3)
                           ->first();
        if(!empty($chk_dept_manager)){
            $role_list = Role::where('id','!=',3)->get();
        } else{
            $role_list = Role::all();
        }
        return response()->json([$get_des_by_deptid,$role_list]);

    }
    public function unqemailchk(){
        $user = User::where('email', Input::get('email'))->first();
        if ($user) {
            return response()->json('Email is already taken');
        } else {
            
            return response()->json('true');
        }
    }
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
        // $userrr = $request->all();
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->image = 'images/'.$new_name;
            $user->role = $request->role;
            $user->mobile_no = $request->mobile_no;
            $user->nid = $request->nid;
            $user->office_id = $request->office_id;
            $user->finger_id = $request->finger_id;
            $user->save();

            if($request->department_id !=null){
            $user_departmetn = new Userdepartment();
            $user_departmetn->department_id = $request->department_id;
            $user_departmetn->user_id = $user->id;
            $user_departmetn->save();
            }
            if($request->designation_id != null){
                $user_designation = new Userdesignation();
                $user_designation->designation_id = $request->designation_id;
                $user_designation->user_id = $user->id;
                $user_designation->save();
            }
            if($request->department_id != null){
            $department_name = Department::select('department_name','id')->where('id','=',$request->department_id)->first();
            }else{
                $department_name="N/A";
            }
            if($request->designation_id !=null){
             $designation_name = Designation::select('designation_name','id')->where('id','=',$request->designation_id)->first();
            } else{
                $designation_name="N/A";
            }
              $pass = $request->password;
               //Mail::to($request->email)->send(new WelcomeMail($user,$pass));
            //   dispatch(new WelcomeEmailJob());
            //   $emailJob = (new WelcomeEmailJob())->delay(Carbon::now()->addSeconds(3));
            //   dispatch($emailJob);
             //return $user;
             Mail::to($request->email)->queue(new WelcomeMail($user,$pass));


            return response()->json([$user,$department_name,$designation_name]);
    }
    public function getuserinfobyid($userid){
        $user_basicinfo = User::select('name','email','image','id','nid','mobile_no','office_id','finger_id')
                        ->where('id','=',$userid)
                        ->first();
        
        return response()->json($user_basicinfo);

    }
    public function getusereditinfo($userid){
        $user_basicinfo = User::select('name','email','image','id','nid','mobile_no','office_id','finger_id','role')
                        ->where('id','=',$userid)
                        ->first();
        $user_department = Userdepartment::where('user_id','=',$userid)->first();
        $user_designation = Userdesignation::where('user_id','=',$userid)->first();
        if(!empty($user_department)){
            $remaining_dept = Department::where('id','!=',$user_department->department_id)->get();
           
        } else{
            $remaining_dept = Department::all();
        }

        if(!empty($user_designation) && !empty($user_department) ){
            $remaining_desi = Designation::where('department_id','=',$user_department->department_id)->where('id','!=',$user_designation->designation_id)->get();
        } elseif(!empty($user_department)){
            $remaining_desi  = Designation::where('department_id','=',$user_department->department_id)->get();
        } else {
            $remaining_desi ='';
        }
        if(!empty($user_department)){
            $chk_dept_manager = DB::table('users')
                            ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                            ->where('userdepartments.department_id','=',$user_department->department_id)
                            ->where('users.role','=',3)
                            ->first();
        }

       
        if(!empty($chk_dept_manager)){
            $user_role = Role::where('id','!=',3)->get();
        } else{
            $user_role = Role::all();
        }

        // $user_role = Role::all();


        return response()->json([$user_basicinfo,$remaining_dept,$remaining_desi,$user_role]);

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
        if($request->file('image')){
           $find_image = User::find($request->user_id);
           $old_img = $find_image->image;
           if($old_img){
            unlink($old_img);
           }
           
           $image = $request->file('image');
           $new_name = rand() . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('images'), $new_name);
           $user = User::find($request->user_id);
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = bcrypt($request->password);
           $user->image = 'images/'.$new_name;
           $user->role = $request->role;
           $user->mobile_no = $request->mobile_no;
           $user->nid = $request->nid;
           $user->office_id = $request->office_id;
           $user->finger_id = $request->finger_id;
           $user->save();
           if($request->department_id){
            $user_departmetn = Userdepartment::where('user_id','=',$request->user_id)->first();
            $user_departmetn->department_id = $request->department_id;
            $user_departmetn->save();
            }
            if($request->designation_id){
            $user_designation = Userdesignation::where('user_id','=',$request->user_id)->first();;
            $user_designation->designation_id = $request->designation_id;
            $user_designation->save();
        }
            $department_name = Department::select('department_name','id')->where('id','=',$request->department_id)->first();
            $designation_name = Designation::select('designation_name','id')->where('id','=',$request->designation_id)->first();
            return response()->json([$user,$department_name,$designation_name]);
          
        } else{

            $user = User::find($request->user_id);
           $user->name = $request->name;
           $user->email = $request->email;
           $user->password = bcrypt($request->password);
           $user->role = $request->role;
           $user->mobile_no = $request->mobile_no;
           $user->nid = $request->nid;
           $user->office_id = $request->office_id;
           $user->finger_id = $request->finger_id;
           $user->save();
           if($request->department_id){
            $user_departmetn = Userdepartment::where('user_id','=',$request->user_id)->first();
                if(!empty($user_departmetn)){
                    $user_departmetn->department_id = $request->department_id;
                    $user_departmetn->save();
                }else{
                    $newdepartment = new Userdepartment();
                    $newdepartment->department_id = $request->department_id;
                    $newdepartment->user_id = $request->user_id;
                    $newdepartment->save();
                }
            }
            if($request->designation_id){
                $user_designation = Userdesignation::where('user_id','=',$request->user_id)->first();
                if(!empty($user_designation)){
                    $user_designation->designation_id = $request->designation_id;
                    $user_designation->save();
                } else{
                    $newdesignation = new Userdesignation();
                    $newdesignation->designation_id = $request->designation_id;
                    $newdesignation->user_id = $request->user_id;
                    $newdesignation->save();

                }
                
            }
            $department_name = Department::select('department_name','id')->where('id','=',$request->department_id)->first();
            $designation_name = Designation::select('designation_name','id')->where('id','=',$request->designation_id)->first();
           return response()->json([$user,$department_name,$designation_name]);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_user = User::find($id);
        $unlink_img = $delete_user->image;
        $delete_user->delete();
        unlink($unlink_img);
    }
}

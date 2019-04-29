<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Userdepartment;
use App\Userdesignation;
use App\User;
use Validator;
use DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $department_list = Department::all();
        // $department_list = DB::select('SELECT userdepartments.user_id,users.name,userdepartments.department_id from userdepartments Left Join users ON userdepartments.user_id = users.id WHERE user_id IN (SELECT id
        // FROM users 
        // WHERE role =3 )');
        // $department_list = DB::table('departments')
        //            ->select('departments.id','departments.department_name','userdepartments.user_id')
        //            ->leftJoin('userdepartments','departments.id','=','userdepartments.department_id')
        //            ->get();
        // $data = DB::table("click")
	    // ->select(DB::raw("COUNT(*) as count_row"))
	    // ->orderBy("created_at")
	    // ->groupBy(DB::raw("year(created_at)"))
        // ->get();
        // $department_list = DB::table('departments')
        //                    ->select(DB::raw("COUNT(userdepartments.department_id) as member"))
        //                    ->leftJoin('userdepartments','departments.id','=','userdepartments.department_id')
        //                    ->groupBy('departments.department_name')
        //                    ->get();
        
        // $department_list = DB::select('SELECT COUNT(userdepartments.department_id) as noofmember, departments.department_name, departments.id as deptid from departments INNER JOIN userdepartments ON departments.id = userdepartments.department_id GROUP BY (departments.department_name)');
        // $departments_mng = DB::table('departments')
        //                 ->join($departmentlist, 'departmentlist', function ($join) {
        //                     $join->on('departments.id', '=', 'departmentlist.department_id');
        //                 })->get();
        return view('Backend.Department.department',compact('department_list'));
        
    }
    public function unqnamecheck(){
        $find_name = Department::where('department_name',Input::get('department_name'))->first();
        if($find_name){
            return response()->json('Name is already taken');
        } else{
            return response()->json('true');
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
        
        $validator = Validator::make($request->all(), [
            'department_name' => 'unique:departments|max:255'
        ]);
        if($validator->passes()){
            $department = new Department();
            $department->department_name = $request->department_name;
            $department->save();
            return response()->json($department);
              
        }else{
            return response()->json('exist');
        }
    }

    public function departmentdetails($deptid){
        $find_all_manager = DB::table('users')
                            ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                            ->where('users.role','=',3)
                            ->select('users.name','users.id')
                            ->get();
       $chk_dept_manager = DB::table('users')
                        ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                        ->where('userdepartments.department_id','=',$deptid)
                        ->where('users.role','=',3)
                        ->select('userdepartments.user_id','userdepartments.department_id')
                        ->first();
       
        $find_ass_mng_by_dept = DB::table('users')
                                ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                                ->where('users.role','=',4)
                                ->where('userdepartments.department_id','=',$deptid)
                                ->select('users.id','users.name')
                                ->get();
        if(!empty($find_ass_mng_by_dept)){
            $myaddedids = array( );
                $i = 0;
                foreach($find_ass_mng_by_dept as $addedid){
                    $i++;
                    $myaddedids[$i] = $addedid->id;
                }
                $find_all_assmanager = User::whereNotIn('id', $myaddedids) 
                                        ->where('role','=',4)
                                        ->get();
                }else{
                    $find_all_assmanager = User::where('role','=',4) ->get();
        }

        $find_existing_member = DB::table('users')
                                ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                                ->where('users.role',5)
                                ->where('userdepartments.department_id','=',$deptid)
                                ->select('users.id','users.name','userdepartments.department_id','userdepartments.user_id',)
                                ->get();
       
        if(!empty($find_existing_member)){
            $myaddedmember = array( );
            $i = 0;
            foreach($find_existing_member as $addedmember){
                $i++;
                $myaddedmember[$i] = $addedmember->id;
            }
            $remainingmemberid_from_userdept = Userdepartment::select('user_id')->get();
            if(!empty($remainingmemberid_from_userdept)){
                $dept_has_user = array();
                $i = 0;  
                foreach($remainingmemberid_from_userdept as $value){
                    $i++;
                    $dept_has_user[$i] = $value->user_id;
                }
                
            }

            $remainingmember = DB::table('users')
                                ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                                 ->whereNotIn('users.id', $dept_has_user)
                                //  ->where('userdepartments.department_id','!=',$deptid)
                                ->where('users.role',5)
                                ->select('users.name','users.id','userdepartments.department_id')
                                ->get();
            // $remainingmember = DB::table('users')
            //                    ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
            //                    ->whereNotIn('users.id', $myaddedmember)
            //                    ->where('users.role',5)
            //                    ->select('users.name','users.id','userdepartments.department_id')
            //                    ->get();
            // $final_rem = array( );
            // foreach($remainingmember as $deptlessuser){
            //     $i++;
            //     if($deptlessuser->department_id =='null')
            //     $final_rem[$i] = 
            // }
        }else{
            // $remainingmember = User::where('role',5)->get(); 
            // $remainingmember = DB::table('users')
            //                    ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
            //                    ->where('users.role',5)
            //                    ->where('userdepartments.department_id','=','null')
            //                    ->select('users.name','users.id','userdepartments.department_id')
            //                    ->get();
            $remainingmemberid_from_userdept = Userdepartment::select('user_id')->get();
            if(!empty($remainingmemberid_from_userdept)){
                $dept_has_user = array();
                $i = 0;  
                foreach($remainingmemberid_from_userdept as $value){
                    $i++;
                    $dept_has_user[$i] = $value->user_id;
                }
                
            }

            $remainingmember = DB::table('users')
                                ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                                 ->whereNotIn('users.id', $dept_has_user)
                                // ->where('userdepartments.department_id','!=',$deptid)
                                ->where('users.role',5)
                                ->select('users.name','users.id')
                                ->get();
        }
    return response()->json([$find_all_manager,$chk_dept_manager,$find_all_assmanager,$find_ass_mng_by_dept,$find_existing_member,$remainingmember]);
    }
  public function removeassistantmanager($assmng,$deptid){
      $find_dept_ass_mng = Userdepartment::where('user_id',$assmng)->where('department_id',$deptid)->first();
      $find_dept_ass_mng->delete();
      return response()->json('deleted');
   }
   public function removemember($memberid,$deptid){
    $find_dept_member = Userdepartment::where('user_id',$memberid)->where('department_id',$deptid)->first();
    $find_dept_member->delete();
    return response()->json('deleted');
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
    public function changedepartmentrowmng($managerid){
        $find_dept = DB::table('departments')
                    ->leftJoin('Userdepartments','departments.id','=','Userdepartments.department_id')
                    ->select('departments.department_name','Userdepartments.department_id')
                    ->where('Userdepartments.user_id',$managerid)
                    ->first();
        if(!empty($find_dept)){
            return response()->json($find_dept);
        }
    }
    public function update(Request $request)
    {  
        //$data =  $request->all();
        
        $find_existing_manager = DB::table('users')
                                ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                                ->where('users.role',3)
                                ->where('userdepartments.department_id','=',$request->dept_id)
                                ->select('userdepartments.id')
                                ->first();
         if($request->manager_id){
            if($find_existing_manager){
                $find_mng_from_user_dept = Userdepartment::find($find_existing_manager->id);
                $find_mng_from_user_dept->delete();
                $update_dept_mng = Userdepartment::where('user_id',$request->manager_id)->first();
                if( $update_dept_mng){
                    $update_dept_mng->department_id = $request->dept_id;
                    $update_dept_mng->save();
                }else{
                    $update_dept_mng = new Userdepartment();
                    $update_dept_mng->user_id = $request->manager_id;
                    $update_dept_mng->department_id = $request->dept_id;
                    $update_dept_mng->save();

                }
                }else{
                    $update_dept_mng = new Userdepartment();
                    $update_dept_mng->user_id = $request->manager_id;
                    $update_dept_mng->department_id = $request->dept_id;
                    $update_dept_mng->save();

                }
           } 

        if($request->assmanager_id){
            foreach($request->assmanager_id as $assistantmanager){
                $find_existing_ass_mng = Userdepartment::where('user_id',$assistantmanager)->first();
                if($find_existing_ass_mng){
                    $find_existing_ass_mng->department_id = $request->dept_id;
                    $find_existing_ass_mng->save();
                } else{
                    $update_dept_mng1 = new Userdepartment();
                    $update_dept_mng1->user_id = $assistantmanager;
                    $update_dept_mng1->department_id = $request->dept_id;
                    $update_dept_mng1->save();

                }
            }
        }
        if($request->teammember_id){
            foreach($request->teammember_id as $teammember){
                $find_existing_member = Userdepartment::where('user_id',$teammember)->first();
                if($find_existing_member){
                    $find_existing_member->department_id = $request->dept_id;
                    $find_existing_member->save();
               }else{
                  $newmember = new Userdepartment();
                  $newmember->user_id = $teammember;
                  $newmember->department_id=$request->dept_id; 
                  $newmember->save(); 
               }
 
            }
        }


        $find_final_manager = DB::table('users')
                            ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                            ->leftJoin('departments','departments.id','=','userdepartments.department_id')
                            ->where('users.role',3)
                            ->where('userdepartments.department_id','=',$request->dept_id)
                            ->select('userdepartments.department_id','users.id as userid','users.name','departments.department_name')
                            ->first();
        
        return response()->json($find_final_manager);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_department = Department::find($id);
        $find_dept_desig = DB::table('designations')
                           ->leftJoin('userdesignations','designations.id','=','userdesignations.designation_id')
                           ->where('designations.department_id',$id)
                           ->select('userdesignations.id')
                           ->get();
                           //return  $find_dept_desig->id;  
        if(!empty($find_dept_desig)){
            foreach($find_dept_desig as $delid){
                
                $find_userdesid = Userdesignation::find($delid->id);
                $find_userdesid->delete();
            }
            
        }
        $delete_department->delete();

    }
}

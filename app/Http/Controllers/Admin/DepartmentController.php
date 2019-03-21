<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Userdepartment;
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
        return view('Backend.Department.department',compact('department_list'));
        //
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
        $department = new Department();
        $department->department_name = $request->department_name;
        $department->save();
        return response()->json($department);

    }

    public function departmentdetails($deptid){
        $find_all_manager = DB::table('users')
                            ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                            ->where('users.role','=',3)
                            ->get();
        $find_all_assmanager = DB::table('users')
                        ->leftJoin('userdepartments','users.id','=','userdepartments.user_id')
                        ->where('users.role','=',4)
                        ->get();
    return response()->json([$find_all_manager,$find_all_assmanager]);
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
        $delete_department = Department::find($id);
        $delete_department->delete();

    }
}

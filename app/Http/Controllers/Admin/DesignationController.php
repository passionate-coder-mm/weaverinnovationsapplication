<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Designation;
use App\Department;
use DB;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department_list = Department::all();
        $designation_list = DB::table('designations') 
                            ->leftJoin('departments','departments.id','=','designations.department_id')
                            ->select('designations.designation_name','designations.id as desigid','designations.department_id','departments.department_name')
                            ->get();
        return view('Backend.Designation.designation',compact('department_list','designation_list'));
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
        $designation = new Designation();
        $designation->department_id = $request->department_id;
        $designation->designation_name = $request->designation_name;
        $designation->save();
        $designation_department = DB::table('designations') 
                                ->leftJoin('departments','departments.id','=','designations.department_id')
                                ->select('designations.designation_name','designations.id as desigid','designations.department_id','departments.department_name')
                                ->where('designations.id','=',$designation->id)
                                ->first();

        return response()->json($designation_department);
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
    public function remainingdepartment($deptid){
        $remaining_dept = Department::where('id','!=',$deptid)->get();
        return response()->json($remaining_dept);

    }
    public function update(Request $request)
    {
        $updated_desig = Designation::find($request->designation_id);
        $updated_desig->designation_name = $request->designation_name;
        $updated_desig->department_id = $request->department_id;
        $updated_desig->save();
        $designation_department = DB::table('designations') 
                                    ->leftJoin('departments','departments.id','=','designations.department_id')
                                    ->select('designations.designation_name','designations.id as desigid','designations.department_ids','departments.department_name')
                                    ->where('designations.id','=',$request->designation_id)
                                    ->first();
        //$updated_desig = $request->all();
        return response()->json($designation_department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_designation  = Designation::find($id);
        $delete_designation->delete();
    }
}

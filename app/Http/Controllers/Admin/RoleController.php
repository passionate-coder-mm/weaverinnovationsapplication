<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use Validator;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_list = Role::orderBy('id','desc')->get();
       return view('Backend.Role.role',compact('role_list'));
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
    public function uniqueroletest(){
        $unique_test_query = Role::where('role_name','=',Input::get('role_name'))->first(); 
        if($unique_test_query){
            return response()->json('Name is already taken');
        } else{
            return response()->json('true');
        }
    }
    public function store(Request $request)
    {   
        $validation = Validator::make($request->all(), [
            'role_name' => 'required|unique:roles'
           ]);
        // $unique_test_query = Role::where('role_name','=',Input::get('role_name'))->first(); 
        if($validation->passes()){
            $role = new Role();
            $role->role_name = $request->role_name;
            $role->save();
            return response()->json($role);
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
    public function unqtestforrolemodal(Request $request){
        $name = Input::get('role_name');
        
        //$data = $request->all();
        //$unique_test_query = Role::where('role_name','=',Input::get('role_name'))->where('id','!=',$roleid)->first(); 

        // if($unique_test_query){
        //     return response()->json('Name is already taken');
        // } else{
        //     return response()->json('true');
        // }
        return response()->json($name);
    }
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role_name' => 'required'
           ]);
            if($validation->passes()){
                $updated_role = Role::find($request->role_id);
                $updated_role->role_name = $request->role_name;
                $updated_role->save();
                return response()->json($updated_role);
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
        //
    }
}

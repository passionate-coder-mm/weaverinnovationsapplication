<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Team;
use App\Userteam;
use DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $teammembers_from_user = User::whereBetween ('role',[3,5])->get();
        $team_info = DB::table('teams')
                     ->leftJoin('users','teams.teamleader_id','users.id')
                     ->select('teams.id as teamid','teams.team_name','teams.status','teams.created_at','users.id as userid','users.name as teamleader_name')
                     ->get();
    
        return view('Backend.Team.team',compact('teammembers_from_user','team_info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    public function unqnamechk(){
      $find_existing_name = Team::where('team_name',Input::get('team_name'))->first();
      if($find_existing_name){
        return response()->json('Name is already taken');
        }else{
            return response()->json('true');
        }
    }
    public function unqnameforedit(){
        $find_existing_name = Team::where('team_name',Input::get('team_name'))->first();
        if(!empty($find_existing_name)){
            $existing_id =  $find_existing_name->id;
            $find_existing_name_id = Team::where('team_name',Input::get('team_name'))->where('id','!=',$existing_id)->first();
            if( $find_existing_name_id){
                return response()->json('Name is already taken');

            }else{
                return response()->json('true');
            }
 
        }else{
            return response()->json('true');
        }
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $team = new Team();
        $team->team_name = $request->team_name;
        $team->teamleader_id = $request->teamleader_id;
        $team->save();
       
        if($request->teammember_id){
            foreach($request->teammember_id as $teammember){
                // $all_id[] = $teammember;
                $userteam = new Userteam();
                $userteam->team_id = $team->id;
                $userteam->user_id = $teammember;
                $userteam->save();
           }
         }
        $teamwithleader = DB::table('teams')
                        ->leftJoin('users','teams.teamleader_id','users.id')
                        ->select('teams.id as teamid','teams.team_name','teams.status','teams.created_at','users.id as userid','users.name as teamleader_name')
                        ->where('teams.id','=',$team->id)
                        ->first();
        $remaining_user = User::whereBetween ('role',[3,5])->select('name','id')->get(); 
         
        return response()->json([$teamwithleader,$remaining_user]);

    }
    public function getteaminfobyteam($teamid){
        $teamwithleader = DB::table('teams')
                        ->leftJoin('users','teams.teamleader_id','users.id')
                        ->select('teams.id as teamid','teams.team_name','teams.created_at','teams.status','users.id as userid','users.name as teamleader_name')
                        ->where('teams.id','=',$teamid)
                        ->first();
        $teammembers = Userteam::where('team_id','=',$teamid)->get();
        $newArray=[];
        foreach($teammembers as $teammember){
             $find_user_info = User::find($teammember->user_id);
             $newArray[$find_user_info->id]['name'] = $find_user_info->name; 
             $newArray[$find_user_info->id]['id'] =  $find_user_info->id; 
        }
       return response()->json([$teamwithleader,$newArray]);
    }

    public function getdatabyteam($teamid){
        $teamwithleader = DB::table('teams')
                        ->leftJoin('users','teams.teamleader_id','users.id')
                        ->select('teams.id as teamid','teams.team_name','teams.created_at','users.id as userid','users.name as teamleader_name')
                        ->where('teams.id','=',$teamid)
                        ->first();
        $remaining_teamleader = User::where('id','!=',$teamwithleader->userid)->whereBetween('role',[3,5])->get();
       
        $teammembers = Userteam::where('team_id','=',$teamid)->get();
         $myaddedids = array( );
         $i = 0;
        foreach($teammembers as $addedid){
            $i++;
            $myaddedids[$i] = $addedid->user_id;
        }
       $remaining_teammembers = User::whereNotIn('id', $myaddedids) 
                ->whereBetween('role',[3,5])
                 ->get();
       
        $newArray=[];
        foreach($teammembers as $teammember){
             $find_user_info = User::find($teammember->user_id);
             $newArray[$find_user_info->id]['name'] = $find_user_info->name; 
             $newArray[$find_user_info->id]['id'] =  $find_user_info->id; 
        }
       return response()->json([$teamwithleader, $newArray,$remaining_teamleader,$remaining_teammembers]);
    }

    public function removeuserfromteam($exeid,$teamid){
        $find_user_by_team  = Userteam::where('team_id','=',$teamid)->where('user_id','=',$exeid)->first();
        $find_user_by_team->delete();
        return response()->json($find_user_by_team);

    }
    //team status update
    public function updateteamstatus($id,$teamid){
        $update_teamstate  = Team::find($teamid);
        $update_teamstate->status = $id;
        $update_teamstate->save();
        return response()->json($update_teamstate);

    }

    // public function getdatabyteam($teamid){
    //     $teamwithleader = DB::table('teams')
    //                     ->leftJoin('users','teams.teamleader_id','users.id')
    //                     ->select('teams.id as teamid','teams.team_name','teams.created_at','users.id as userid','users.name as teamleader_name')
    //                     ->where('teams.id','=',$teamid)
    //                     ->first();
    //     $teammembers = Userteam::where('team_id','=',$teamid)->first();
    //     $members_id = json_decode($teammembers->user_id);
    //     $newArray=[];
    //     foreach($members_id as $member){
    //         $find_member = User::find($member);
    //         $newArray[$find_member->name]['name'] = $find_member->name;
    //         $newArray[$find_member->name]['id'] = $find_member->id;

    //     }
    //     return response()->json([$teamwithleader,$newArray]);

    // }
    // public function removeuserfromteam($exeid,$teamid){
    //     $find_user_by_team  = Userteam::where('team_id','=',$teamid)->first();
    //     $jsondecodedid = json_decode($find_user_by_team->user_id);
    //     $new = [];
    //     foreach ($jsondecodedid as $userid){
    //         if ($exeid != $userid){
    //             $new[] = $userid;
    //         }
    //     }
    //     $find_user_by_team->user_id = json_encode($new);
    //     $find_user_by_team->save();

    //     return response()->json($find_user_by_team);

    // }

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
        $updated_team =Team::find($request->team_id);
        $updated_team->team_name = $request->team_name;
        $updated_team->teamleader_id = $request->teamleader_id;
        $updated_team->save();
        if($request->teammember_id){
            foreach($request->teammember_id as $teammember){
                $new_mem = new Userteam();
                $new_mem->user_id = $teammember;
                $new_mem->team_id = $updated_team->id;
                $new_mem->save();  
            }
        }
        
        $teamwithleader = DB::table('teams')
                        ->leftJoin('users','teams.teamleader_id','users.id')
                        ->select('teams.id as teamid','teams.team_name','teams.status','teams.created_at','users.id as userid','users.name as teamleader_name')
                        ->where('teams.id','=',$updated_team->id)
                        ->first();
        
        return response()->json($teamwithleader);
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

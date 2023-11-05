<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Http\Resources\GroupUserResource;
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups=Group::all();


        // $groups = Group::leftJoin('posts', 'posts.group_id', '=', 'groups.id')
        // ->leftJoin('users', 'users.id', '=', 'posts.user_id')
        // ->select('groups.name as group_name', 'posts.post', 'users.name as user_name','users.image')
        // ->get();

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $group=new Group;
        
       $user=Auth::guard('sanctum')->user();
       
        $group->user_id=$user->id;
        $group->name=$request->name;
             
        $group->save();
      
        return $group;

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        
        return new GroupUserResource($group);
        
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        $isAdmin=Auth::guard('sanctum')->user()->role;
       
        if($group->user_id==Auth::guard('sanctum')->user()->id||$isAdmin=="admin")
         { 
        
            $group->update($request->all());
            return $group;
         }
        else{
            return response("Forbidden:you can’t update this group",403);
         }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $isAdmin=Auth::guard('sanctum')->user()->role;
        if($group->user_id==Auth::guard('sanctum')->user()->id||$isAdmin=="admin")
         { 
        
            $group->delete();
            
            return response("group deleted",204);
         }
         else{
            return response("Forbidden:you can’t delete this group",403);
        }

    }

    public function join(Request $request){

        $userGroups=new UserGroup;
        $userGroups->group_id=$request->group_id;
        $userGroups->user_id=Auth::guard('sanctum')->user()->id;
        
        $userGroups->save();
    }


  
}

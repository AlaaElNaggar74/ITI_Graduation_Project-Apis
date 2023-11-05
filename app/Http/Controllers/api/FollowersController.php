<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\FollowersResource;
class FollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $followers=new Follower;
        $followers->lawyer_id=$request->lawyer_id;
        $followers->user_id=Auth::guard('sanctum')->user()->id;

        $followers->save();

        //return $followers;

    }

    /**
     * Display the specified resource.
     */
    public function show($lawyerId)
    {
        $lawyer_id=Lawyer::find($lawyerId);

     
        if(!$lawyer_id)
          return response([],404);

        $users=$lawyer_id->followers;
    

         return new FollowersResource($users);

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($followerId)
    {
    //     $lawyer=Auth::guard('sanctum')->user();
    //     //dd($lawyer);
    //     $lawyer_id=$lawyer->id;
    //   // dd($lawyer_id);
    //     $follower = Follower::find($followerId);

    //     //dd($follower->lawyer_id);
    //     if($lawyer_id==$follower->lawyer_id){
    //         $lawyer->followers()->detach($follower);
    //         return response("the follower deleted successfullty",204);
    //     }

    //     else{
    //         return response([],401);
    //     }

        $lawyer=Auth::guard('sanctum')->user();
        $lawyer_id=$lawyer->id;

        $follower=DB::table('user_follow_lawyer')
            ->join('lawyers', 'user_follow_lawyer.lawyer_id', '=', 'lawyers.id')
            ->where('user_follow_lawyer.user_id',$lawyer_id)
            ->where('user_follow_lawyer.id', $followerId);
            
        
           
            $follower->delete();
    

        //return response('deleted successfully',204);
        
    }
}

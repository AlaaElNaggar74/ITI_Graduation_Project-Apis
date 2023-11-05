<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\LawyerResource;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ShowReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //     $review=Review::all();
    //    return $review;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

          
        $validator = Validator::make($request->all(), [
            "rate"=>"min:1|max:5"
        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $review=Review::create($request->all());
          return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lawyer=DB::table('lawyers')
        ->join('lawyer_times', 'lawyers.id', '=', 'lawyer_times.lawyer_id')
        ->join('appointments', 'lawyer_times.id', '=', 'appointments.lawyer_time_id')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->join('reviews', 'appointments.id', '=', 'reviews.appointment_id')
        ->where('lawyers.id', '=', $id)
        ->select('reviews.rate','reviews.comment','reviews.created_at','users.name')
        ->get();
 
        $lawyer_id=Lawyer::find($id);

        if(!$lawyer_id)
          return response([],404);
  
        
        return new ReviewResource($lawyer);
         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$reviewId)
    {
        $user=Auth::guard('sanctum')->user();
        $user_id=$user->id;

       


        $review=DB::table('reviews')
        ->join('appointments','reviews.appointment_id','=','appointments.id')
        ->join('users','appointments.user_id','=','users.id')
        ->where('appointments.user_id', $user_id)
        ->where('reviews.id',$reviewId);  
    
       
        $review->update($request->all());
       
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($reviewId)
    {
        $user=Auth::guard('sanctum')->user();
        $user_id=$user->id;


      
        $review=DB::table('reviews')
        ->join('appointments','reviews.appointment_id','=','appointments.id')
        ->join('users','appointments.user_id','=','users.id')
        ->where('appointments.user_id', $user_id)
        ->where('reviews.id',$reviewId);  

         $review->delete();

    }
}

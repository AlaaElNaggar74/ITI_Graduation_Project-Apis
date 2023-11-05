<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\LawyerTime;
use Illuminate\Http\Request;
use App\Http\Resources\LawyerTimeResource;
use App\Http\Resources\LawyerResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class LawyerTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         //$lawyer=LawyerTime::all();
        // dd($lawyer);
        
        //return LawyerResource::collection($lawyer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
          $LawyerTime=LawyerTime::create($request->all());
          return $LawyerTime;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
         $lawyerTime=DB::table('lawyers')
        ->join('lawyer_times', 'lawyers.id', '=', 'lawyer_times.lawyer_id')
        ->where('lawyers.id', '=', $id)
        ->select('lawyer_times.start_hour','lawyer_times.end_hour','lawyer_times.day')
        ->get();

        // dd($lawyers);

        //dd($lawyer->lawyerTime);
       // return $lawyer->lawyerTime;

    //    $lawyer = Lawyer::with('lawyerTime')->get();
     //dd($lawyer);

      $lawyer=Lawyer::find($id);
     
      if(!$lawyer)
        return response([],404);

      //$lawyerTime= LawyerTime::where('lawyer_id',$id)->get();



      return new LawyerTimeResource($lawyerTime);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$lawyerId)
    {
        $lawyer = Lawyer::find($lawyerId);

        if (!$lawyer) {
            return response([], 404);
        }
    

        $lawyerTimeRecords = $lawyer->lawyerTime;
 
        foreach ($lawyerTimeRecords as $lawyerTimeRecord) {
            $day = $lawyerTimeRecord->day;
            if($day==$request->day){
                $recordData = array_merge($request->all(), ['day' => $day]);
                $lawyerTimeRecord->update($recordData);
                return response()->json(['message' => 'Lawyer time records updated successfully']);
            }
            
        }
    
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$lawyerId)
    {
        $lawyer = Lawyer::find($lawyerId);

       
        if (!$lawyer) {
            return response([], 404);
        }
    
       
        $lawyerTimeRecords = $lawyer->lawyerTime()->where('day', $request->day)->get();
    
        foreach ($lawyerTimeRecords as $lawyerTimeRecord) {
            $lawyerTimeRecord->delete();
        }
    
        // return response()->json(['message' => 'Lawyer time records for ' . $request->day . ' deleted successfully']);
        return response("Lawyer time records for ' . $request->day . ' deleted successfully",204);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email"=>['unique:users','required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"unique:users|required",
            "password"=>"required|min:8",
            'image' => 'required',


        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

    

        $request_data = $request->all();
        if($request->hasFile("image")){
            $image = $request->file('image');

             $originalFilename = $image->getClientOriginalName();

             //dd($originalFilename);
             $imageName = time() . '_' . $originalFilename;

            $path = $image->storeAs("userImages",$imageName,'image_uploads');

            $request_data["image"]=$imageName;

         
        }
  
     $user= User::create($request_data);
      
      return new UserResource($user);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $validator = Validator::make($request->all(), [
            "name"=>"required|min:3",
            "email"=>['required','email',function ($attribute, $value, $fail) {
                if (!str_contains($value, '.com')) {
                    $fail('The '.$attribute.' must include ".com".');
                }
            }],
            "phone"=>"required",
            "password"=>"required|min:8",
            'image' => 'required',

        ]);
     
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $request_data = $request->all();
        if($request->hasFile("image")){
            $image = $request->file('image');

             $originalFilename = $image->getClientOriginalName();

             //dd($originalFilename);
             $imageName = time() . '_' . $originalFilename;

            $path = $image->storeAs("userImages",$imageName,'image_uploads');

            $request_data["image"]=$imageName;

         
        }
        
        $user->update($request_data);
        
      
       //return new UserResource($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
       $loggedUser=Auth::guard('sanctum')->user();
       //dd($user->id);
        if($loggedUser->role=='admin'||$loggedUser->id==$user->id){
            $user->delete();

            return response("user deleted",204);
        }
       else{
        return response("Forbidden:you can’t delete this user",403);
       }
    }
}

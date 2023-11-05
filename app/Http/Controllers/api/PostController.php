<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $post=Post::create($request->all());
        // return $post;
        $group_post=new Post;
        $group_post->post=$request->post;
        $group_post->user_id=Auth::guard('sanctum')->user()->id;
        
        $group_post->group_id=$request->group_id;
             
        $group_post->save();
      
        return $group_post;
    }

    /**
     * Display the specified resource.
     */
    public function show($groupId)
    {
        $group = Group::find($groupId);
       
        $posts = $group->hasPost;
       
        if(!$group)
          return response([],404);

        return new PostResource($posts);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if($post->user_id==Auth::guard('sanctum')->user()->id){

            $post->update($request->all());
        }

        else{ 
           return response("Forbidden:you can’t update this post",403);
             
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->user_id==Auth::guard('sanctum')->user()->id){

          $post->delete();
          return response("group deleted",204);
        }
        else{
            return response("Forbidden:you can’t delete this post",403);  
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'organization_id' => 'required|numeric',
            'comment' => 'required|string|min:3',

        ]);

            $comment = new Comment;
            $comment->user_id = auth('api')->user()->id;
            $comment->organization_detail_id = $request->organization_id;
            $comment->comment = $request->comment;


            if($comment->save()){
                return response()->json('Successful', 200);
            }
            else{
                throw ValidationException::withMessages([
                    'Error' => ['An error Occur']
                ]);
            }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Comment::where('organization_detail_id', $id)->get(), 200);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if((Comment::find($id)->user_id) == auth('api')->user()->id)
        {

            Comment::destroy($id);
            return response()->json("Successfully Deleted", 200);
        }
        else{
            return response()->json("You are not allow to delete this comment", 200);

        }
    }
}

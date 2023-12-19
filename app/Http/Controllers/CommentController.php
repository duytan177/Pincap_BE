<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\CommentRepo\CommentRepo;
use App\Repositories\MediaRepo\MediaRepo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $commentRepo;
    protected $mediaRepo;
    public function __construct(CommentRepo $commentRepo, MediaRepo $mediaRepo)
    {
        $this->commentRepo = $commentRepo;
        $this->mediaRepo = $mediaRepo;
    }

    public function index()
    {
        return response()->json(1);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        if(!($comment = $this->commentRepo->create($data))){
            return response()->json([
                "error" => "Comment faired"
            ],400);
        }
        return response()->json([
            "message" => "Comment successfully",
            'comment' => $comment
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $comments = $this->mediaRepo->find($id,["userComments"])->userComments;
        return response()->json([
            "comments" => $comments
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        if(!$id){
            return response()->json([
                "error" => "Comment find faired"
            ],400);
        }
        $data = $request->all();
        $this->commentRepo->update($id,$data);
        return  response()->json([
            "message" => "update comment"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if($id){
            $this->commentRepo->delete($id);
            return  response()->json([
                "message" => "delete comment"
            ],200);
        }
    }
}

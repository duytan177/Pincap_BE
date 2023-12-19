<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Repositories\CommentRepo\CommentRepo;
use App\Repositories\ReplyRepo\ReplyRepo;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    protected $replyRepo;


    public function __construct(ReplyRepo $replyRepo,)
    {
        $this->replyRepo = $replyRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(2);
    }

    public function show($id){
        $replies = $this->replyRepo->all(["userRelies"],["*"],["comment_id" => $id]);
        return response()->json([
            "replies" => $replies
        ],200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();
        if(!($reply = $this->replyRepo->create($data))){
            return response()->json([
                "error" => "Reply faired"
            ],200);
        }
        return response()->json([
            "message" => "Reply successfully",
            "reply" => $reply
        ],200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        if(!$id){
            return response()->json([
                "error" => "Reply find faired"
            ],400);
        }
        $data = $request->all();
        $this->replyRepo->update($id,$data);
        return  response()->json([
            "message" => "update reply"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        if($this->replyRepo->delete($id)){
            return response()->json([
                "message" => "Delete reply successfully"
            ],200);
        }
        return response()->json([
            "error" => "Delete reply faired"
        ],400);

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ReactionReply;
use App\Repositories\ReactionReplyRepo\ReactionReplyRepo;
use Illuminate\Http\Request;

class ReactionReplyController extends Controller
{
    protected $reactionReplyRepo;
    public function __construct(ReactionReplyRepo $reactionReplyRepo)
    {
        $this->reactionReplyRepo = $reactionReplyRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(3);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data =$request->all();
        if(!($reaction = $this->reactionReplyRepo->create($data))){
            return response()->json([
                "error" => "Error reaciton"
            ],400);
        }
        return response()->json([
            "message" => "Reaction successfully",
            "reaction" => $reaction
        ],200);
    }

    /**
     * Display the specified resource.

     */
    public function show($id)
    {
        $reactionComment = $this->reactionReplyRepo->all([
            'reaction',
            'userReaction' => ['id','firstName','lastName','email']],
            ['*'],
            ["reply_id" => $id]
        );
        return response()->json([
            'reactionMedia' => $reactionComment,
            'countReaction' => count($reactionComment)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        //
        if($this->reactionReplyRepo->delete($id)){
            return response()->json([
                "message" => "Delete reaction comment successfully"
            ],200);
        }
        return response()->json([
            "error" => "Delete reaction comment failed"
        ],400);
    }
    public function update(Request $request,  $id)
    {
        //
    }

}

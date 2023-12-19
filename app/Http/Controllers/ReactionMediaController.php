<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\ReactionMedia;
use App\Repositories\MediaRepo\MediaRepo;
use App\Repositories\ReactionMediaRepo\ReactionMediaRepo;
use App\Repositories\UserRepo\UserRepo;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Http\Request;

class ReactionMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $reactionMediaRepo;
    protected $mediaRepo;

    public function __construct(ReactionMediaRepo $reactionMediaRepo, MediaRepo $mediaRepo)
    {
        $this->reactionMediaRepo = $reactionMediaRepo;
        $this->mediaRepo = $mediaRepo;
    }

    public function show($id)
    {
        //
        $reactionMedia = $this->reactionMediaRepo->all([
            'reaction',
            'userReaction' => ['id','firstName','lastName','email']],
            ['*'],
            ['media_id' => $id]);
        return response()->json([
            'reactionMedia' => $reactionMedia,
            'countReaction' => count($reactionMedia)
        ],200);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        if(!$data){
            return response()->json([
                "error" => "Data error reaction media"
            ],400);
        }
        $media = $this->mediaRepo->find($data['media_id']);
        $media->reactionUser()->attach($data['user_id'] , [
            'id' => Guid::uuid4()->toString(),
            'feeling_id' => $data['feeling_id']
        ]);
        return response()->json([
            "reactionMedia" => $media
        ],200);
    }

    public function delete($id){
        if($this->reactionMediaRepo->delete($id)){
            return response()->json([
                "message" => "Delete reaction comment successfully"
            ],200);
        }
        return response()->json([
            "error" => "Delete reaction comment failed"
        ],400);
    }

}

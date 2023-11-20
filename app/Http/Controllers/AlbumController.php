<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Repositories\AlbumRepo\AlbumRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Guid\Guid;
use Tymon\JWTAuth\Facades\JWTAuth;

class AlbumController extends Controller
{
    protected $albumRepo;
    public function __construct(AlbumRepo $albumRepo)
    {
        $this->albumRepo = $albumRepo;
//        $this->middleware('checkRole')->only(['store','index']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listAlbums = Album::with('medias')->get();
        return response()->json([
            'listAlbums' => $listAlbums
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestDataAll = $request->all();
        $album = $this->albumRepo->create($requestDataAll);
        if(!$requestDataAll['albumOwner_id']){
            return response()->json([
                'message' => "Created album failed"
            ],400);
        }
        $album->userOwner()->attach([
            $requestDataAll['albumOwner_id'] => [
                'id' => Guid::uuid4()->toString(),
                'isUserOwner' => True
            ]
        ]);
        if($album){
            return response()->json([
                'data' => $album
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detailAlbum = Album::with(['userOwner','medias'])->find($id);
        return response()->json([
            "detailAlbum" => $detailAlbum
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $detailAlbum = $this->albumRepo->find($id);
        return response()->json([
            'detailAlbum' => $detailAlbum
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $album = $this->albumRepo->find($id);
        if($album){
            $dataAll = $request->all();
            if($this->albumRepo->update($id,$dataAll)){
                return response()->json([
                    "message" =>"Updated album successfully"
                ],200);
            }
            return response()->json([
                "message" => "Updated album failed"
            ],400);
        }
        return response()->json([
            "message" => "No find Album"
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $album = Album::with("medias")->find($id);
        if($album){
            //deleted relationship album and medias after deleted album
            $album->medias()->detach();
            $this->albumRepo->delete($id);
            return response()->json([
                "message" => "Deleted Album successfully"
            ],200);
        }
        return response()->json([
            "message" => "No deleted album"
        ],400);
    }

    public function addUsersToJoinAlbum(Request $request,$id){
        $listUsersId = $request->listUsers_id;
        foreach ($listUsersId as $key => $listUserId){

        }
        return $listUsersId;
    }
}

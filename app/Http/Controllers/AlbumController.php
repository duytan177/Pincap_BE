<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\UserAlbum;
use App\Repositories\AlbumRepo\AlbumRepo;
use App\Repositories\MediaRepo\MediaRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Guid\Guid;
use Tymon\JWTAuth\Facades\JWTAuth;

class AlbumController extends Controller
{
    protected $albumRepo;
    protected $mediaRepo;
    public function __construct(AlbumRepo $albumRepo,MediaRepo $mediaRepo)
    {
        $this->albumRepo = $albumRepo;
        $this->mediaRepo = $mediaRepo;
//        $this->middleware('checkRole')->only(['store','index']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listAlbums = $this->albumRepo->paginate(5,['members','userOwner','medias']);
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
        if($album){
            return response()->json([
                'data' => $album
            ],200);
        }
        return response()->json([
            'message' => "Created album failed"
        ],400);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $detailAlbum = $this->albumRepo->find($id,['medias']);
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
        $detailAlbum = $this->albumRepo->find($id,["medias"]);
        return response()->json ([
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
        $album = $this->albumRepo->find($id,["medias","members"]);

        if($album){
            //deleted relationship album and medias after deleted album
            $medias = $album->medias;
            $members = $album->members;
//            foreach ($medias as $key => $value){
//                $media =  $this->mediaRepo->find($value->id);
//                $this->mediaRepo->update($media->id,['isDeleted' => 1]);
//            }

            $album->members()->detach();
            $album->medias()->detach();
            $this->albumRepo->delete($id);
            return response()->json([
                "message" => "Deleted Album successfully"
            ],200);
        }
        return response()->json([
            "message" => "Deleted album faired"
        ],400);
    }

    public function addUsersToJoinAlbum(Request $request,$album_id){
        //validator request before handle data
        $validator = Validator::make($request->all(), [
            'listUsers_id.*' => 'required|unique:user_album,user_id',
        ]);
        //check request has any errors then return messages errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ],400);
        }
        $listUsersId = $request->listUsers_id;
        $album = $this->albumRepo->find($album_id);
        foreach ($listUsersId as $key => $listUserId){
            $album->userOwner()->attach([
                $listUserId => [
                    'id' => Guid::uuid4()->toString(),
                    "created_at"=> now()
                ]
            ]);
        }
        return response()->json([
            "message" => "invitation sent successfully"
        ],200);
    }

    public function archive(Request $request){
        $album_id = $request->input("album_id");
        $album = $this->albumRepo->find($album_id);
        $album->isArchived?$isArchived = 0:$isArchived = 1;
        if($this->albumRepo->update($album_id,["isArchived" => $isArchived])){
            return response()->json([
                "message"=>"successfully"
            ],200);
        }else{
            return response()->json([
                "message"=>"fairled"
            ],200);
        }
    }
}

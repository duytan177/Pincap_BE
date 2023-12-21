<?php

namespace App\Http\Controllers;

use App\Enums\Album_Media\Privacy;
use App\Enums\Album_Media\MediaType;
use App\Http\Requests\MediaRequest;
use App\Models\Album;
use App\Models\AlbumMedia;
use App\Models\Media;
use App\Repositories\MediaRepo\MediaRepo;
use App\Repositories\TagRepo\TagRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Guid\Guid;
use ZipArchive;

class MediaController extends Controller
{
    protected $mediaRepo;
    protected $tagRepo;
    public function __construct(MediaRepo $mediaRepo,TagRepo $tagRepo)
    {
        $this->mediaRepo = $mediaRepo;
        $this->tagRepo = $tagRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listMedia = $this->mediaRepo->paginate(5,['albums','userOwner','mediaReported']);
        return response()->json([
            'listMedia' => $listMedia
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $listMediaType = MediaType::getKeys();
        $listMediaPrivacy = Privacy::getKeys();
        return response()->json([
            'listMediaType' => $listMediaType,
            'listMediaPrivacy' => $listMediaPrivacy,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //Get request file after upload to file AWS s3 and return url file
        $file = $request->file('medias');
//        return $file->getClientOriginalName();
        $mediaURL = $this->uploadMediaToS3($file);
//        //save medias to database in laravel
        $dataAll= $request->except(["medias",'album_id']);
        $dataAll['mediaURL'] = $mediaURL;
        $mediaNew = $this->mediaRepo->create($dataAll);
        if(!$mediaNew)    {
            return response()->json([
                'message' => "Created media failed",
            ],400);
        }
        if($dataAll['tagName']){
            foreach ($dataAll['tagName'] as $key => $value){
                $tag = $this->tagRepo->create([
                    "tagName" => $value,
                    "ownerUserCreated_id" => $mediaNew->mediaOwner_id
                ]);
                $tag->medias()->attach([
                    $mediaNew->id => ['id' => Guid::uuid4()->toString()]
                ]);
            }
        }
        if($request->album_id){
            $mediaNew->albums()->attach([
                $request->album_id => ['id' => Guid::uuid4()->toString()]
            ]);
        }
        return response()->json([
            'message' => "Created media successfully",
            "media" => $mediaNew
        ],200);


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $media = $this->mediaRepo->find($id,['userOwner']);
        return response()->json([
            'media'=> $media
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $media = $this->mediaRepo->find($id);
        return response()->json([
            'media'=> $media
        ],200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //check if media exists on aws s3
        $mediaUpdate = $this->mediaRepo->find($id);
        $dataAll = $request->except('medias');
        if($request->file('media')){
            $mediaPathOld = $this->extractPathFromS3URLs($mediaUpdate->mediaURL)[0];
            if(Storage::disk('s3')->exists($mediaPathOld)){
                return response()->json([
                    'media'=> $mediaPathOld
                ],200);
            }
            $medias = $request->file('medias');
            $mediaURL = $this->uploadMediaToS3($medias);
            $dataAll['mediaURL'] = $mediaURL;
        }
        $media = $this->mediaRepo->update($id,$dataAll);
        return response()->json([
            'message' => "Update media successfully"
        ],200);
    }

    /**
     * Remove the specified resource from storage.

     */
    public function destroy($id)
    {
        $media = $this->mediaRepo->find($id);
        if($media){
            $this->mediaRepo->update($id,['isDeleted'=>1]);
            return response()->json([
                'message' => "Deleted Successfully"
            ],200);
        }
        return response()->json([
            'message' => "Deleted media failed"
        ],400);

    }

    public function findMediaByTag(Request $request){
        $param = [
            "tagName"
        ];
        $keyword = $request->input("searchMedia");
        $tag = $this->tagRepo->findByField($param,$keyword,2,['medias']);
        if($tag->isEmpty()){
            return response()->json([
                "message" => "No search medias"
            ],404);
        }else{
            return response()->json([
                "medias" => $tag
            ],200);
        }
    }

    public function createByImageAI(Request $request){
        $pythonAPI = "http://127.0.0.1:5000/createImageByAI";
        $data = [
            'prompt' =>  $request->prompt,
            'size' => $request->size,
            'n' => 1
        ];
        $response = Http::get($pythonAPI,$data);

        return response()->json($response->json(),200);
    }


    public function downloadMedias(Request $request){
        $pathFromS3 = $this->extractPathFromS3URLs($request->URLs);
        if(count($pathFromS3) == 1){
            Storage::disk("s3")->download($pathFromS3[0]);
            return  Storage::disk("s3")->download($pathFromS3[0]);
        }
        $zip = new \ZipArchive();
        $fileNameZip = "download.zip";
        if($zip->open(public_path($fileNameZip), ZipArchive::CREATE)===True){
            foreach ($pathFromS3 as $key => $value ){
                $fileContent = Storage::disk('s3')->get($value);
                $zip->addFromString(basename($value),$fileContent);
            }
            $zip->close();
        }
        return response()->download(public_path($fileNameZip));
    }

    public function uploadMediaToS3($file){
        $medias =    explode(".", $file->getClientOriginalName());
        $fileName = $medias[0].".".time().".".$medias[1];
        $mediaFolder = ($medias[1]=="mp4")?'/Video':'/Image';
        $url = $file->storeAs($mediaFolder,$fileName,'s3');
        $url = Storage::disk('s3')->url($url);
        return $url;
    }
    public function extractPathFromS3URLs($mediaURLs){
        $result = [];
        foreach ($mediaURLs as $mediaURL) {
            $mediaPathFromS3 = explode("/", $mediaURL);
            $result[] =  '/' . $mediaPathFromS3[count($mediaPathFromS3) - 2] . "/" . end($mediaPathFromS3);
        }
        return $result;
    }


}

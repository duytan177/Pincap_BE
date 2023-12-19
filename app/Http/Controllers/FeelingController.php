<?php

namespace App\Http\Controllers;

use App\Models\Feeling;
use App\Repositories\FeelingRepo\FeelingRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNan;

class FeelingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $feelingRepo;
    public function __construct(FeelingRepo $feelingRepo)
    {
        $this->feelingRepo = $feelingRepo;
    }

    public function index()
    {
        //
        $feelings = $this->feelingRepo->all();
        return response()->json([
            'feelings' => $feelings
        ],200);
    }


    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $data = $request->except('icon');
        $file = $request->icon;
        $url =  $file->storeAs("/Icon",$file->getClientOriginalName(),'s3');
        $url = Storage::disk('s3')->url($url);
        $data['icon_url'] = $url;
        if( $feelings = $this->feelingRepo->create($data)){
            return response()->json([
                'feelings' =>$feelings
            ],200);
        }
        return response()->json([
            'error' => "Created feeling failed"
        ],400);

    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        if($feeling = $this->feelingRepo->find($id)){
            return response()->json([
                'feeling' => $feeling
            ],200);
        }
        return response()->json([
            'error' => 'feeling is not available'
        ],400);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        if(!empty($data['icon'])){
            $feeling =  $this->feelingRepo->find($id);
            $icon_url = explode('/',$feeling->icon_url);
            $pathIcon = $icon_url[count($icon_url)-2] .'/'. end($icon_url);
            Storage::disk('s3')->delete($pathIcon);
            $file = $data['icon'];
            $url =  $file->storeAs("/Icon",$file->getClientOriginalName(),'s3');
            $url = Storage::disk('s3')->url($url);
            $data['icon_url'] = $url;
        }
        if ($this->feelingRepo->update($id,$data)){
            return response()->json([
                'message' => "updated feeling successfully"
            ],200);
        }
        return response()->json([
            'error' => "Updated feeling failed"
        ],400);
    }

    /**
     * Remove the specified resource from storage.

     */
    public function destroy($id)
    {
        //
        $feeling = $this->feelingRepo->find($id);
        if($feeling){
            $this->feelingRepo->delete($id);
            $icon_url = explode('/',$feeling->icon_url);
            $pathIcon = $icon_url[count($icon_url)-2] .'/'. end($icon_url);
            Storage::disk('s3')->delete($pathIcon);
            return response()->json([
                'message' => "Deleted feeling successfully"
            ],200);
        }
        return response()->json([
            'error' => "Deleted feeling failed"
        ],400);

    }


}

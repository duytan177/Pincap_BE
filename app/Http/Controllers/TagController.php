<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Repositories\TagRepo\TagRepo;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tagRepo;
    public function __construct(TagRepo $tagRepo)
    {
        $this->tagRepo = $tagRepo;
    }

    public function index()
    {
//        $listTag =  Tag::with("medias")->get();
        $listTag = Tag::with("userOwner")->whereHas('userOwner', function ($query){
            $query->where("role",1);
        })->get();
        return response()->json([
           "listTag" => $listTag
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
     *
     */
    public function store(Request $request)
    {
        //
//        $dataAll = $request->all();
        $tag = $this->tagRepo->create($request->all());
        return response()->json([
            "tag" => $tag,
            "message" => "Created tag successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

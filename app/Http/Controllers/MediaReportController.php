<?php

namespace App\Http\Controllers;

use App\Models\MediaReport;

use App\Repositories\MediaRepo\MediaRepo;
use App\Repositories\MediaReportRepo\MediaReportRepo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MediaReportController extends Controller
{
    private $mediaReportRepo;
    public function __construct(MediaReportRepo $mediaReportRepo)
    {
        $this->mediaReportRepo = $mediaReportRepo;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $withRelation = [
            'reasonReport' => ['id','title','description'],
            'userReport' => ['id','firstName','lastName','role'],
            'reportMedia'
        ];
        $reportMedias = $this->mediaReportRepo->paginate(5,$withRelation);
        return response()->json([
            "reportMedias" => $reportMedias,
        ],200);;
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

        $validator =   Validator::make($request->all(),[
            'reason_report_id' => ["required_without:other_reasons"],
            'other_reasons' => ["required_without:reason_report_id"],
        ]);
        if($validator->fails()){
            return response()->json([
                "message" => $validator->errors()
            ],400);;
        }
        $requestDataAll = $request->all();

        $reportMedia = $this->mediaReportRepo->create($requestDataAll);
        return response()->json([
            "reportMedia" => $reportMedia,
        ],200);;
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
     *
     */
    public function edit($id)
    {
        //
        $withRelation = [
            'reasonReport' => ['id','title','description'],
            'userReport' => ['id','firstName','lastName','role'],
            'reportMedia'
        ];
        $reportMedia = $this->mediaReportRepo->find($id,$withRelation);
        return response()->json([
            "reportMedia" => $reportMedia,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $requestDataAll = $request->all();
        $this->mediaReportRepo->update($id,$requestDataAll);
        return response()->json([
            "message" => "Updated report media successfully"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->mediaReportRepo->delete($id);
        return response()->json([
            "message" => "Deleted report media successfully"
        ],200);
    }
}

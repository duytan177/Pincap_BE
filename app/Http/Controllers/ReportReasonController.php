<?php

namespace App\Http\Controllers;

use App\Models\ReportReason;
use App\Repositories\ReportReasonRepo\ReportReasonRepo;
use Illuminate\Http\Request;

class ReportReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $reasonReportRepo;
    public function __construct(ReportReasonRepo $reasonReportRepo)
    {
        $this->reasonReportRepo = $reasonReportRepo;
    }

    public function index()
    {
        //
        $reasonReport = $this->reasonReportRepo->all();
        return response()->json([
            "reportMedia" => $reasonReport,
        ],200);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
        //
        $requestDataAll = $request->all();
        $this->reasonReportRepo->create($requestDataAll);
        return response()->json([
            "message" => "report reason Created successfully",
        ],200);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

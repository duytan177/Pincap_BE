<?php

namespace App\Http\Controllers;

use App\Models\ReactionReply;
use Illuminate\Http\Request;

class ReactionReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(4);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReactionReply  $reactionReply
     * @return \Illuminate\Http\Response
     */
    public function show(ReactionReply $reactionReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReactionReply  $reactionReply
     * @return \Illuminate\Http\Response
     */
    public function edit(ReactionReply $reactionReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReactionReply  $reactionReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReactionReply $reactionReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReactionReply  $reactionReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReactionReply $reactionReply)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ReactionComment;
use Illuminate\Http\Request;

class ReactionCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(3);
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
     * @param  \App\Models\ReactionComment  $reactionComment
     * @return \Illuminate\Http\Response
     */
    public function show(ReactionComment $reactionComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReactionComment  $reactionComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ReactionComment $reactionComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReactionComment  $reactionComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReactionComment $reactionComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReactionComment  $reactionComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReactionComment $reactionComment)
    {
        //
    }
}

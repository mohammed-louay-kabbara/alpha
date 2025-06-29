<?php

namespace App\Http\Controllers;

use App\Models\comment_reactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'type' => 'required',
            'type_id' => 'required',
            'reaction' => 'required',
        ]);
        $comment_reactions=comment_reactions::where('user_id',Auth::id())
            ->where('commentable_type',$request->type)
            ->where('commentable_id',$request->type_id)->first();
        if ($comment_reactions == null ) {
        comment_reactions::create([
            'user_id' => Auth::id(),
            'commentable_type' => $request->type,
            'commentable_id' => $request->type_id,
            'reaction' => $request->reaction
        ]);
        return response()->json(['تم إضافة تفاعلك'], 200);
        }
        else {
            $comment_reactions->delete();
            return response()->json(['تم حذف تفاعلك'], 200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(comment_reactions $comment_reactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comment_reactions $comment_reactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comment_reactions $comment_reactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comment_reactions $comment_reactions)
    {
        //
    }
}

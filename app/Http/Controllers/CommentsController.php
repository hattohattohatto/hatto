<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * ミドルウェアでのバリデーション
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('comment.validate')->only(['store', 'update']);
    }

    /**
     * コメント保存
     *
     * @param Request $request
     * @param Comment $comment
     * 
     * @return \Illuminate\Foundation\helpers
     */
    public function store(Request $request, Comment $comment)
    {
        $userId = auth()->id();
        $commentData = $request->all();
        $comment->commentStore($userId, $commentData);

        return back();
    }
}

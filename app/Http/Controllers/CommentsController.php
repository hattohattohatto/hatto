<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $this->middleware('comment')->only(['store', 'update']);
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
        $user = auth()->user();
        $data = $request->all();
        $comment->commentStore($user->id, $data);

        return back();
    }
}

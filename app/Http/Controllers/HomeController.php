<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * 新規コントローラーの認証生成
     * 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * homeのページを表示
     * 
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $searchWord = $request->input('searchWord');

        return view('home', [
            'searchWord' => $searchWord,
        ]);
    }
}

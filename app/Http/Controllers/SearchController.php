<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tweet;
use App\Models\User;

class SearchController extends Controller
{


    public function show(Request $request)
    {
        $searchWord = $request->input('searchWord');

        return view('searchTweet', [
            'searchWord' => $searchWord,
        ]);
    }

    public function search(User $user, Request $request)
    {
        //入力される値nameの中身を定義する
        $searchWord = $request->input('searchWord'); //商品名の値

        $query = Tweet::query();

        //商品名が入力された場合、m_productsテーブルから一致する商品を$queryに代入
        if (isset($searchWord)) {
            $query->where('text', 'like', '%' . self::escapeLike($searchWord) . '%');
        }
        $products = $query->paginate(15);

        return view('searchTweet', [
            'user' => $user,
            'products' => $products,
            'searchWord' => $searchWord,
        ]);
    }

    //「\\」「%」「_」などの記号を文字としてエスケープさせる
    public static function escapeLike($str)
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $str);
    }
}

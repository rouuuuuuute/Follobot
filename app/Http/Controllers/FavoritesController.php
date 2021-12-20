<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('twitter.favorites');
    }

    public function create(Request $request)
    {
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $account_id = $request->account_id;
        $data = DB::table('favorites')->where('account_id', '=',$account_id)->count();
        if($data < 1) {
            $request->validate([
                'favorite_keyword' => 'required | string | max:255',
                'favorite_keyword2' => 'string | max:255'
            ]);
            $favorite = new Favorite;
            $favorite->account_id = $request->account_id;
            $favorite->favorite_keyword = $request->favorite_keyword;
            $favorite->favorite_keyword2 = $request->favorite_keyword2;
            $favorite->logic = $request->logic;
            $favorite->save();
            return redirect('/twitter/keywords/favorites')->with('flash_message', '登録しました');
        } else {
            return view('twitter.favorites')->with('flash_message', '登録できませんでした。登録済みのものを削除してください');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'favorite_keyword' => 'required | string | max:255',
            'favorite_keyword2' => 'string | max:255'
        ]);
        $account_id = $request->account_id;
        $id = DB::table('favorites')->where('account_id','=', $account_id)->value('id');
        $followkeyword = Favorite::find($id);
        $followkeyword ->fill($request->all())->save();
        return redirect('/twitter/keywords/favorites')->with('flash_message', '更新しました');
    }

    public function destroy(Request $request)
    {
        $account_id = $request->account_id;
        Favorite::where('account_id',$account_id)->delete();
        return redirect('/twitter/keywords/favorites')->with('flash_message', '削除しました');

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FollowKeyword;
use Illuminate\Support\Facades\DB;


class FollowKeywordsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('twitter.followkeywords');
    }


    public function create(Request $request)
    {
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $account_id = $request->account_id;
        $data = DB::table('follow_keywords')->where('account_id', '=', $account_id)->count();
        if ($data < 1) {
            $request->validate([
                'keyword' => 'required | string |max:255',
                'keyword2' => 'string |max:255'
            ]);
            $followkeyword = new FollowKeyword;
            $followkeyword->account_id = $request->account_id;
            $followkeyword->keyword = $request->keyword;
            $followkeyword->keyword2 = $request->keyword2;
            $followkeyword->logic = $request->logic;
            $followkeyword->save();
            return redirect('/twitter/keywords/follow')->with('flash_message', '登録しました');
        } else {
            return redirect('/twitter/keywords/follow')->with('flash_message', '登録できませんでした。登録済みのものを削除してください');
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'keyword' => 'required | string |max:255',
            'keyword2' => 'string |max:255'
        ]);
        $account_id = $request->account_id;
        $id = DB::table('follow_keywords')->where('account_id','=', $account_id)->value('id');
        $followkeyword = FollowKeyword::find($id);
        $followkeyword ->fill($request->all())->save();
        return redirect('/twitter/keywords/follow')->with('flash_message', '更新しました');

    }

    public function destroy(Request $request)
    {
        $account_id = $request->account_id;
        FollowKeyword::where('account_id',$account_id)->delete();
        return redirect('/twitter/keywords/follow')->with('flash_message', '削除しました');

    }

}

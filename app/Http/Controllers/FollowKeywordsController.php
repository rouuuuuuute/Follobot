<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FollowKeyword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FollowKeywordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::id();
        $screen_names = DB::table('twitter_accounts')->where('user_id', '=', $user_id)->pluck('screen_name');
        return view('twitter.followkeywords', ['screen_names' => $screen_names]);
    }


    public function create(Request $request)
    {
        //ToDo 複数登録しようとしたときに、現状だとelseでとばされるだけなので、エラーメッセージがでるようにする
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $screen_name = $request->screen_name;
        $account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
        $data = DB::table('follow_keywords')->where('account_id', '=', $account_id)->count();
        if ($data < 1) {
            $request->validate([
                'keyword' => 'required | string |max:255'
            ]);
            $followkeyword = new FollowKeyword;
            $followkeyword->account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
            $followkeyword->keyword = $request->keyword;
            $followkeyword->save();
            return redirect('/twitter/keywords/follow')->with('flash_message', __('Registerd'));
        } else {
            $user_id = Auth::id();
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=', $user_id)->pluck('screen_name');
            return view('twitter.followkeywords', ['screen_names' => $screen_names]);

        }
    }

}

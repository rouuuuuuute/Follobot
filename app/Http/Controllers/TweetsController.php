<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Tweet;

class TweetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user_id = Auth::id();
        $screen_names = DB::table('twitter_accounts')->where('user_id', '=',$user_id)->pluck('screen_name');
        return view ('twitter.tweets',['screen_names' => $screen_names ]);

    }

    public function create(Request $request)
    {
        //ToDo 複数登録しようとしたときに、現状だとelseでページにとばされて登録できたかどうかわからないので、エラーメッセージがでるようにする
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $screen_name = $request->screen_name;
        $account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
        $data = DB::table('tweets')->where('account_id', '=',$account_id)->count();
        if($data<1) {
            $request->validate([
                'tweet' => 'required | string |max:144',
                'reserved_at' => 'required | string |max:144'
            ]);
            $tweet = new Tweet;
            $tweet->account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
            $tweet->tweet = $request->tweet;
            $tweet-> reserved_at = $request->reserved_at;
            $tweet->save();
            return redirect('/twitter/tweets')->with('flash_message', __('Registerd'));
        }else{
            $user_id = Auth::id();
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=', $user_id)->pluck('screen_name');
            return view('twitter.tweets', ['screen_names' => $screen_names]);
        }
    }
}

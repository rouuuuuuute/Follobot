<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RequestTokenService;
use App\Services\AccessTokenService;
use App\TwitterAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TwitterAccountsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //Twitter連携を許可した場合とキャンセルした場合の条件分岐
        if( isset( $_GET["oauth_token"] ) && isset( $_GET["oauth_verifier"] ) ) {
            $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
            $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
            $callback_url = 'http://127.0.0.1:8000/twitter/accounts';
            $request_token_secret = session("oauth_token_secret") ;
            $request_url = "https://api.twitter.com/oauth/access_token";
            $request_method = "POST";

            //アクセストークン取得用のサービスクラスをよびだす
            $access_token = new AccessTokenService($api_key,$api_secret,$callback_url,$request_token_secret,$request_url,$request_method);
            $query = $access_token -> request();

            //DBに情報を登録
            $twitteraccount = new TwitterAccount;
            $twitteraccount->user_id = Auth::id();
            $twitteraccount->twitter_id = $query['user_id'];
            $twitteraccount->screen_name = $query['screen_name'];
            $twitteraccount->oauth_token = $query['oauth_token'];
            $twitteraccount->oauth_token_secret = password_hash($query['oauth_token_secret'], PASSWORD_DEFAULT);
            $twitteraccount->save();

            //ToDo 重複登録したときにエラー表示が出るようにすること。
            return redirect('/twitter/accounts')->with('flash_message',__('Registerd'));

        } elseif ( isset( $_GET["denied"] ) ) {
            echo "連携を拒否しました。";
            $user_id = Auth::id();
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=',$user_id)->pluck('screen_name');
            return view ('twitter.accounts',['screen_names' => $screen_names ]);
        } else{
            $user_id = Auth::id();
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=',$user_id)->pluck('screen_name');
            return view ('twitter.accounts',['screen_names' => $screen_names ]);
        }
    }

    public function request()
    {
        //１０個以上アカウント登録ができないように、データの数を取得して、１０個以上なら登録できないようにする
        $user_id = Auth::id();
        $data = DB::table('twitter_accounts')->where('user_id', '=',$user_id)->count();
        if($data<10) {

            $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
            $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
            $callback_url = 'http://127.0.0.1:8000/twitter/accounts';
            $access_token_secret = "";
            $request_url = "https://api.twitter.com/oauth/request_token";
            $request_method = "POST";

            $request_token = new RequestTokenService($api_key, $api_secret, $callback_url, $access_token_secret, $request_url, $request_method);
            $query = $request_token->request();

            //ToDo アカウント登録１０個以上のとき、エラーメッセージだすようにする
            return redirect()->away("https://api.twitter.com/oauth/authorize?oauth_token=" . $query["oauth_token"]);
        }else{
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=',$user_id)->pluck('screen_name');
            return view ('twitter.accounts',['screen_names' => $screen_names ]);
        }
    }
}

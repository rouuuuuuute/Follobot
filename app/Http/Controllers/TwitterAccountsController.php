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
            $twitteraccount->oauth_token_secret = $query['oauth_token_secret'];
            $twitteraccount->save();

            return redirect('/twitter/accounts')->with('flash_message','登録しました');

        } elseif ( isset( $_GET["denied"] ) ) {
            echo "連携を拒否しました。";
            return view ('twitter.accounts');
        } else{
            return view ('twitter.accounts');
        }
    }

    public function request()
    {
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

            return redirect()->away("https://api.twitter.com/oauth/authorize?oauth_token=" . $query["oauth_token"]);
        }else{
            return view ('twitter.accounts');
        }
    }
    public function destroy(Request $request)
    {
        $account_id = $request->account_id;
        TwitterAccount::where('id',$account_id)->delete();
        return view('twitter.accounts')->with('flash_message', '削除しました');

    }
}

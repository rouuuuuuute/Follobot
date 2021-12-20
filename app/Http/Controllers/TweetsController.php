<?php

namespace App\Http\Controllers;

use App\FollowedTarget;
use App\Services\TweetPostService;
use App\Target;
use App\TwitterAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tweet;

use Illuminate\Support\Facades\Log;

class TweetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view ('twitter.tweets');
    }

    public function create(Request $request)
    {
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $account_id = $request->account_id;
        $data = DB::table('tweets')->where('account_id', '=',$account_id)->count();
        if($data<1) {
            $request->validate([
                'tweet' => 'required | string |max:144',
                'reserved_at' => 'required | string |max:144'
            ]);
            $tweet = new Tweet;
            $tweet->account_id = $request->account_id;
            $tweet->tweet = $request->tweet;
            $tweet-> reserved_at = $request->reserved_at;
            $tweet->save();
            return redirect('/twitter/tweets')->with('flash_message', '登録しました');
        }else{
            return redirect('/twitter/tweets')->with('flash_message','登録できませんでした。登録済みのものを削除してください');
        }
    }
    public function edit(Request $request)
    {
        $request->validate([
            'tweet' => 'required | string |max:144',
            'reserved_at' => 'required | string |max:144'
        ]);
        $account_id = $request->account_id;
        $id = DB::table('tweets')->where('account_id','=', $account_id)->value('id');
        $tweet = Tweet::find($id);
        $tweet->account_id = $request->account_id;
        $tweet->tweet = $request->tweet;
        $tweet-> reserved_at = $request->reserved_at;
        $tweet ->save();
        return redirect('/twitter/tweets')->with('flash_message', '更新しました');

    }

    public function destroy(Request $request)
    {
        $account_id = $request->account_id;
        Tweet::where('account_id',$account_id)->delete();
        return redirect('/twitter/tweets')->with('flash_message', '削除しました');

    }

    public function post(Request $request)
    {
        //値のセット
        $account_id = $request->input('id');
        $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
        $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');
        $tweet = Tweet::where('account_id', $account_id)->value('tweet');

        $tweet_post = new TweetPostService($api_key, $api_secret, $access_token, $access_token_secret,$tweet);
        $array = $tweet_post->post();

        Log::debug(print_r($array,true));

        $tweet_error = isset($array['errors'][0]['code']);

        if($tweet_error == 187){
            Log::debug(print_r('過去投稿したものと同じ投稿内容のため投稿できませんでした', true));
            $tweet_post_error = new MailSendController;
            $tweet_post_error->tweet();
        }else{
            //処理が完了したらメールを送る処理
            $finished = new MailSendController;
            $finished->finished();
        }

        return null;
    }

}

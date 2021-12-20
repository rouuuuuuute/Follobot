<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FollowerSearchService;
use App\Services\RateLimitStatusService;
use Illuminate\Support\Facades\DB;

use App\Target;
use App\TwitterAccount;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;


class FollowedTargetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        Log::debug(print_r('///////////////////////////////////////////////////////////////////',true));
        Log::debug(print_r('FollowedTargetsControllerの処理を開始します', true));

        //値のセット
        //screen_nameでは、古い順に並び替えて1つ目のものを取得している。
        //また、FollowingTargetsControllerの処理（フォロー処理）が終わってから対象のターゲットアカウントのupdated_atを更新している
        //それにより１ターゲットアカウントの処理が終わってから、次の処理をするタイミングで、次のターゲットアカウントにうつることができる。

        $account_id = $request->input('id');
        $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
        $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');
        $screen_name = Target::where('account_id', $account_id)->oldest('updated_at')->value('target_name');
        $target_id = Target::where('account_id', $account_id)->oldest('updated_at')->value('id');


        Log::debug(print_r('ターゲットアカウント名の表示',true));
        Log::debug(print_r($screen_name,true));
        Log::debug(print_r($target_id,true));

        //最初にリクエスト上限の確認
        $search = new RateLimitStatusService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $account_id);
        $json = $search->search();

        $array = json_decode($json, true);
        $ratelimit = Arr::collapse($array);

        //凍結時メールを送信して処理をとめる
        if (isset($array['errors'][0]['code'])) {
            if ($array['errors'][0]['code'] == 326) {
                $suspend = new MailSendController;
                $suspend->suspended();
                Log::debug(print_r('アカウントが凍結されました', true));
                $arr = [];
                $arr = array('susBool' => 0);
                $suspended = json_encode($arr);
                return $suspended;
            }
        }

        $follower_remaining = $ratelimit['followers']['/followers/list']['remaining'];
        $follower_reset = $ratelimit['followers']['/followers/list']['reset'];

        Log::debug(print_r('Ratelimitの表示',true));
        Log::debug(print_r($follower_remaining,true));

        //remaining(残りリクエスト回数)が0以上のときは,フォロワーターゲットリストを作成する処理
        //remainingが0のときは、15分以上待って再施行してもらうようメッセージを表示
        //フレンドシップ（サーチ）上限170/15minより、FollowerSearchServiceで設定するフォロワー取得(count)は170までとしている

        if ($follower_remaining > 14) {
            //TwitterAPIを使ってターゲットアカウントのフォロワーをサーチしてDBに登録する処理を入れている
            $search = new FollowerSearchService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $account_id,$target_id);
            $data = $search->search();

            //アカウント名が誤っているときは$data[0]['description']が定義されていないため、それを判断し定義されているときは上記APIが問題なく動いていると判断しフォローする処理に移行している
            if (isset($data[0]['description'])) {
                //アカウント名があっているときはフォロー処理に移行
                Log::debug(print_r($data[0]['description'], true));
                Log::debug(print_r('FollowingTargetsControllerの処理を開始します', true));
                Log::debug($account_id);

                return redirect()->action('FollowingTargetsController@create', ['account_id'=>$account_id,'target_id'=>$target_id]);
            } else {
                //ToDo アカウントが間違っている内容のメールを送る
                //アカウント名が間違っているときは、ターゲットアカウントが誤っている旨を表示
                Log::debug(print_r($data[0]['code'], true));

                //メール

                Log::debug(print_r('アカウントが間違っている。一時停止処理', true));
                $arr = [];
                $arr = array('susBool' => 0);
                $suspended = json_encode($arr);
                return $suspended;
            }
        } else {
            //remainingが14のときは、フォロワーターゲットリストはつくらずフォロー処理に移行
            Log::debug(print_r('サーチ170/15min上限よりフォロー処理に移行', true));
            return redirect()->action('FollowingTargetsController@create', ['account_id'=>$account_id,'target_id'=>$target_id]);
        }
    }
}

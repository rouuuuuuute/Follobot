<?php

namespace App\Http\Controllers;

use App\FollowedTarget;
use App\FollowingTarget;
use App\Services\RateLimitStatusService;
use App\Target;
use App\TwitterAccount;
use Illuminate\Http\Request;
use App\Services\FollowingService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class FollowingTargetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        Log::debug(print_r('///////////////////////////////////////////////////////////////////', true));
        Log::debug(print_r('FollowingTargetControllerの処理を開始します', true));

        //値のセット
        $account_id = $request->input('account_id');
        $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
        $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');
//        $target_name = $request->input('target_name');
//        $target_id = Target::where('target_name', $target_name)->where('account_id', $account_id)->value('id');
        $target_id = $request->input('target_id');
        $screen_names = FollowedTarget::where('target_id', $target_id)->pluck('followed_name');

        Log::debug(print_r('アカウントID,targetID,screen_namesの配列を表示',true));
        Log::debug(print_r($account_id,true));
        Log::debug(print_r($target_id,true));
        Log::debug(print_r($screen_names,true));

        //本日のフォロー数をカウント
        //15分前から何件取得したかカウント
        $today = date('Y-m-d');
        $minutes = date('Y-m-d H:i:s', strtotime('now -15 min'));
        $todaycount = FollowingTarget::where('target_id', $target_id)->whereDate('created_at', $today)->count();
        $minutescount = FollowingTarget::where('target_id', $target_id)->where('created_at', '>', $minutes)->count();
        $name_count = DB::table('followed_targets')->where('target_id', $target_id)->whereDate('created_at', $today)->count();

        Log::debug(print_r('15分前から何件取得したか、本日のフォロー数などを表示',true));
        Log::debug(print_r($today,true));
        Log::debug(print_r($todaycount,true));
        Log::debug(print_r($minutes,true));
        Log::debug(print_r($minutescount,true));

        Log::debug(print_r('フォロワーターゲットに登録されている数を確認', true));
        Log::debug(print_r($name_count,true));

        //if文で制限を超えていない場合はフォロー開始
        //本日のフォロー数が制限以下であるか確認
        if ($todaycount < 1000) {
            Log::debug(print_r('本日のフォロー数は1000件以下', true));

            //ターゲットアカウントより作成したフォロワーターゲットを展開している
            foreach ($screen_names as $screen_name) {
                Log::debug(print_r('配列を展開', true));
                Log::debug(print_r($screen_name, true));

                //一度登録しているフォローアカウントは除外する(ターゲットアカウントもあっていることが条件)
                //途中でやめて再開した場合もこれで対応可能
                $followingBool = DB::table('following_targets')->where('following_name', $screen_name)->where('target_id', $target_id)->exists();
                Log::debug(print_r('過去登録済みか確認', true));
                if ($followingBool) {
                    //処理を次のscreen_nameにスキップ
                    Log::debug(print_r('ターゲットアカウントかつフォロー済みの中に入ってる（過去登録済み）', true));
                    continue;
                } else {
                    //DBに入っていて、ターゲットアカウントが被っているものだけを排除できればよいので、あとはelseで選択
                    Log::debug(print_r('ターゲットアカウントではなく、フォロー済みの中にも入っていない', true));

                    //15分前から15件を超えて登録していた場合はメールを送信
                    if ($minutescount > 14) {
                        Log::debug(print_r('15分以上時間をあけてください', true));
                        $minuteslimit = new MailSendController;
                        $minuteslimit->minuteslimit();
                        break;
                    }

                    Log::debug($screen_name);
                    Log::debug(print_r('フォロー処理開始', true));

                    //フォロー処理＆フォロー済みアカウント登録処理
                    $follow = new FollowingService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                    $array = $follow->following();

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

                    //15分前からのカウント数を再度取得する
                    Log::debug(print_r('15分前からのカウント数を再度取得', true));
                    $minutescount = FollowingTarget::where('target_id', $target_id)->where('created_at', '>', $minutes)->count();
                    Log::debug($minutescount);
                }
            }
        } else {
            Log::debug(print_r('本日は既に1000件以上の登録があるため、時間を置いてお試しください', true));
            $daylimit = new MailSendController;
            $daylimit->daylimit();
        }

        //フォローし終わったので、ターゲットアカウントのupdated_atを更新している
        DB::table('targets')->where('account_id', $account_id)->where('id',$target_id)->update(['updated_at'=>now()]);

        Log::debug(print_r('登録終了アンフォロー処理に移行', true));

        Log::debug(print_r('FollowingTargetControllerの処理を終了しsます', true));
        Log::debug(print_r('///////////////////////////////////////////////////////////////////', true));


        //acount_idをアンフォローコントローラーにわたす
        return redirect()->action('UnfollowersController@create', ['account_id'=>$account_id]);
    }
}


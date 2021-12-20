<?php

namespace App\Http\Controllers;

use App\FollowedTarget;
use App\Services\RateLimitStatusService;
use App\Target;
use App\FollowingTarget;
use App\TwitterAccount;
use App\Unfollower;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\FriendshipSearchService;
use App\Services\UsertimelineSearchService;
use App\Services\UnfollowService;
use App\Favorite;
use App\Services\SearchService;
use App\Services\FavoritesService;


class UnfollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {
        Log::debug(print_r('///////////////////////////////////////////////////////////////////', true));
        Log::debug(print_r('UnfollowersControllerの処理を開始します', true));

        //5000フォロー超えたら開始
        //フォローした日から７日以上経過しているものを抽出してforeachでまわす
        //１日1000件上限こえてないか確認
        //フォロー返ししてくれないユーザーをアンフォロー（フォロ返ユーザー確認サービス）して、アンフォローリストにいれる
        //または、１５日投稿なしの非アクティブユーザーをアンフォロー（投稿確認サービス）して、アンフォローリストにいれる
        //終わったら自動いいね

        //値のセット
        $account_id = $request->input('account_id');
        $api_key = 'dmQHWdKlgRBynzEzOvLMzfAG8';
        $api_secret = '6NC6nlxCyu2E2ZXKbqV8t9EUewbDPQxamKHgZSHM2YITQUUIsW';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');

        //７日前の日付を取得
        $daysgone = date("Y-m-d H:i:s", strtotime("-7 day"));
        Log::debug(print_r('7日前の日付', true));
        Log::debug(print_r($daysgone, true));

        //1ツイッターアカウントのフォローしている総数を取得（全てのターゲットアカウントに紐づくものを取得して合計している）
        Log::debug(print_r('フォローしている数', true));
        $following_counts = Target::withCount('followingTargets')->where('account_id', $account_id)->get();
        $following = 0;
        foreach ($following_counts as $following_count) {
            $following += $following_count->following_targets_count;
        }
        Log::debug(print_r($following, true));

        //アンフォロー開始基準5000フォロー以上
        if ($following > 5000) {

            Log::debug(print_r('フォロー数5000件以上', true));

            //フォローしているうち、フォローしてから７日以上経っているものを抽出
            //フォロワーターゲットを取得して配列で展開し,フォローしてから７日以上経過したフォロー済みのアカウント名を取得している
            $target_arr = Target::where('account_id', $account_id)->pluck('id');
            Log::debug(print_r($target_arr, true));
            foreach ($target_arr as $target_id) {

                //フォローしてから7日以上で、かつ古いもの順で15件取得するようにしている（15分15件制限のため）
                $following_arr = FollowingTarget::where('target_id', $target_id)->whereDate('created_at', '<=', $daysgone)->oldest('updated_at')->take(15)->pluck('following_name')->toArray();
                Log::debug(print_r('ターゲットidからフォロー済みアカウント取得', true));
                Log::debug(print_r($following_arr, true));

                //ターゲットidからフォロー済みのアカウントが取得できない場合（フォローしていない場合）があるため、配列がemptyかどうか判断している
                if (!empty($following_arr)) {
                    //取得したフォロー済みアカウントをforeachで展開
                    foreach ($following_arr as $following_name) {
                        Log::debug(print_r('フォローしたscreen_nameを取得', true));
                        Log::debug(print_r($following_name, true));

                        $screen_name = $following_name;

                        //ratelimit確認
                        $search = new RateLimitStatusService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $account_id);
                        $json = $search->search();
                        $array = json_decode($json, true);
                        $ratelimit = Arr::collapse($array);

                        //フレンドシップ関係取得（フォローアンフォローの関係性）のアクセス制限
                        $friendship_remaining = $ratelimit['friendships']['/friendships/lookup']['remaining'];
                        Log::debug(print_r($friendship_remaining, true));

                        //アクティブ状況取得（ユーザーのタイムラインを取得して最新ツイートの時間を確認）のアクセス制限
                        $timeline_remaining = $ratelimit['statuses']['/statuses/user_timeline']['remaining'];
                        Log::debug(print_r($timeline_remaining, true));

                        if ($friendship_remaining == 0) {
                            //フレンドシップ関係取得のアクセス制限のため、制限にかかったメールを送ってbreak
                            $minuteslimit = new MailSendController;
                            $minuteslimit->minuteslimit();
                            Log::debug(print_r('フレンドシップ関係取得のアクセス制限', true));
                            break;
                        } elseif ($timeline_remaining == 0) {
                            //アクティブ状況取得のアクセス制限のため、制限にかかったメールを送ってbreak
                            $minuteslimit = new MailSendController;
                            $minuteslimit->minuteslimit();
                            Log::debug(print_r('アクティブ状況取得のアクセス制限', true));
                            break;
                        } else {

                            //アンフォローした数を取得
                            $today = date("Y-m-d H:i:s");
                            $todaycount = Unfollower::where('target_id', $target_id)->whereDate('updated_at', $today)->count();
                            Log::debug(print_r('当日アンフォローした数を取得', true));
                            Log::debug(print_r($todaycount, true));

                            //当日のアンフォロー数取得
                            if ($todaycount < 1000) {
                                //当日1000件以下の場合、アンフォロー処理開始
                                Log::debug(print_r('本日のアンフォローした数1000件以下', true));

                                //対象のscreen_nameからフレンドシップ関係およびアクティブ状態の情報をとってくる
                                //フレンドシップ関係取得
                                $friendship = new FriendshipSearchService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                                $friendship_arr = $friendship->search();
                                $friendship_isset = isset($friendships_arr['connections'][1]);
                                Log::debug(print_r('フレンドシップ関係を表示', true));
                                Log::debug(print_r($friendship_arr, true));

                                //アクティブ状況取得
                                $usertimeline = new UsertimelineSearchService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                                $usertimeline_arr = $usertimeline->search();
                                $usertimeline_isset = isset($usertimeline_arr['created_at']);

                                //非アクティブ状況orフォロー返しがない状況のどちらかが成立すればOK
                                //ブロックされている場合や、ユーザーが投稿をしていないときはユーザータイムラインがissetになっているため、まずはissetで判断
                                if ($usertimeline_isset) {
                                    //ユーザータイムラインは存在するため、それが１５日以上前か、フォロー返しされてないかどちらかを判断
                                    //１５日前のユニックスタイムスタンプ取得
                                    $unixtime = time() - (15 * 24 * 60 * 60);
                                    $usertimeline_unix = strtotime($usertimeline_arr['created_at']);

                                    if (!$friendship_isset) {
                                        //$friendships_arr['connections'][1]には、フォローされている状況か、フォローリクエストが届いている状況が入る
                                        //これがissetということは、フォロー返しされていない状態
                                        //フォロー返してくれないユーザーのアンフォロー処理
                                        $unfollow = new UnfollowService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                                        $unfollow_arr = $unfollow->destroy();
                                        Log::debug(print_r('フォロー返ししてくれないユーザー', true));

                                        //凍結時メールを送信して処理をとめる
                                        if (isset($array['errors'][0]['code'])) {
                                            if ($array['errors'][0]['code'] == 326) {
                                                $suspend = new MailSendController;
                                                $suspend->suspended();
                                                $arr = [];
                                                $arr = array('susBool' => 0);
                                                $suspended = json_encode($arr);
                                                return $suspended;
                                            }
                                        }

                                    } elseif ($usertimeline < $unixtime) {
                                        //15日前のユニックスタイムと比較し、それよりも小さければ非アクティブ状況という判断
                                        //非アクティブユーザーのアンフォロー処理
                                        $unfollow = new UnfollowService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                                        $unfollow_arr = $unfollow->destroy();
                                        Log::debug(print_r('ユーザータイムラインを表示', true));
                                        Log::debug(print_r($usertimeline_arr['created_at'], true));
                                        Log::debug(print_r($usertimeline_unix, true));

                                        //凍結時メールを送信して処理をとめる
                                        if (isset($array['errors'][0]['code'])) {
                                            if ($array['errors'][0]['code'] == 326) {
                                                $suspend = new MailSendController;
                                                $suspend->suspended();
                                                $arr = [];
                                                $arr = array('susBool' => 0);
                                                $suspended = json_encode($arr);
                                                return $suspended;
                                            }
                                        }

                                    } else {
                                        //アクティブ状況で、かつフォロー返しもされている状態
                                        //following_targetのupdated_atを更新する（再度following_targetをとってこないように更新しておく）
                                        //後続処理をスキップしてforeachの展開にもどる
                                        Log::debug(print_r('アクティブ状況かつ、フォロー返しもされている状態', true));
                                    }
                                } else {
                                    //usertimelineが存在していないということは、投稿がなくアクティブ状況にないということ。アンフォロー処理にうつる
                                    //アンフォロー処理を書く
                                    $unfollow = new UnfollowService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name, $target_id);
                                    $unfollow_arr = $unfollow->destroy();
                                    Log::debug(print_r('ユーザータイムラインが存在しない（非アクティブ）もしくはブロックされている', true));

                                    //凍結時メールを送信して処理をとめる
                                    if (isset($array['errors'][0]['code'])) {
                                        if ($array['errors'][0]['code'] == 326) {
                                            $suspend = new MailSendController;
                                            $suspend->suspended();
                                            $arr = [];
                                            $arr = array('susBool' => 0);
                                            $suspended = json_encode($arr);
                                            return $suspended;
                                        }
                                    }
                                }
                                //アンフォロー処理が終わったので、//following_targetのupdated_atを更新している
                                //対象のアカウントは、following_targetはoldestで古い順にしてからとってきているため
                                Log::debug(print_r('アンフォロー処理が終わったのでupdated_atを更新する処理', true));
                                DB::table('following_targets')->where('target_id', $target_id)->where('following_name', $screen_name)->update(['updated_at' => now()]);

                            } else {
                                //１日1000件以上のアンフォローをしたためメールを送って処理中断
                                Log::debug(print_r('本日は既に1000件以上の登録があるため、時間を置いてお試しください', true));
                                $daylimit = new MailSendController;
                                $daylimit->daylimit();
                                break;
                            }

                        }

                    }
                } else {
                    Log::debug(print_r('データが入ってない', true));
                    break;
                }
            }
        } else {
            Log::debug(print_r('フォロー数5000件未満のため処理終了', true));
        }

        Log::debug(print_r('UnfollowersControllerの処理を終了します', true));
        Log::debug(print_r('///////////////////////////////////////////////////////////////////', true));
        Log::debug(print_r('自動いいねの処理を開始します', true));


        //////////////////////////////////////////////////////////////////////////////
        //自動いいね処理に移行 ツイートを検索して、いいねする
        //登録しておいたキーワードを取得
        Log::debug(print_r('///////////////////////////////////////', true));
        Log::debug(print_r('自動いいね処理に移行', true));
        $db = Favorite::where('account_id', $account_id)->first();
        $keyword = $db->favorite_keyword;
        $keyword2 = $db->favorite_keyword2;
        $logic = $db->logic;
        if ($logic == 'AND') {
            $q = $keyword . ' ' . $keyword2;
        } elseif ($logic == 'OR') {
            $q = $keyword . ' OR ' . $keyword2;
        } elseif ($logic == 'NOT') {
            $q = $keyword . ' -' . $keyword2;
        } else {
            $q = $keyword;
        }

        Log::debug(print_r('Favoriteキーワード', true));
        Log::debug(print_r($q, true));

        //ツイート検索
        $search = new SearchService($api_key, $api_secret, $access_token, $access_token_secret, $q);
        $tweets_arr = $search->search();

        Log::debug(print_r('ツイートを検索してJSON取得した', true));
        Log::debug(print_r('いいね処理開始', true));

        //取得した配列を展開、その前に配列が存在するかを確認している。
        foreach ($tweets_arr as $tweet_arr) {
            if (isset($tweet_arr['id'])) {
                $tweet_id = $tweet_arr['id'];
                $favorites = new FavoritesService($api_key, $api_secret, $access_token, $access_token_secret, $tweet_id);
                $favorite_json = $favorites->favorite();

                $array2 = json_decode($favorite_json, true);
                //凍結時メールを送信して処理をとめる
                if (isset($array2['errors'][0]['code'])) {
                    if ($array2['errors'][0]['code'] == 326) {
                        $suspend = new MailSendController;
                        $suspend->suspended();
                        $arr = [];
                        $arr = array('susBool' => 0);
                        $suspend = json_encode($arr);
                        return $suspend;
                    }
                }

            }else{
                return redirect('/home')->with('flash_message', '登録された「自動いいね」キーワードで情報が取得できないか、既に自動いいね処理を行っております。');
            }
        }

        //処理が完了したらメールを送る処理
        $finished = new MailSendController;
        $finished->finished();

        return null;

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //ToDo Twitterアカウントが登録されていない場合nullを許容していないので、エラーになる。Twitterアカウントを登録してくださいの表記をだすべき
    public function index()
    {
        $user_id = Auth::id();
        $screen_names = DB::table('twitter_accounts')->where('user_id', '=', $user_id)->pluck('screen_name');
        return view('twitter.favorites', ['screen_names' => $screen_names]);
    }

    public function create(Request $request)
    {
        //ToDo 複数登録しようとしたときに、現状だとelseでとばされるだけなので、エラーメッセージがでるようにする
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $screen_name = $request->screen_name;
        $account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
        $data = DB::table('favorites')->where('account_id', '=',$account_id)->count();
        if($data < 1) {
            $request->validate([
                'favorite_keyword' => 'required | string | max:255'
            ]);
            $favorite = new Favorite;
            $favorite->account_id = DB::table('twitter_accounts')->where('screen_name', '=', $screen_name)->value('id');
            $favorite->favorite_keyword = $request->favorite_keyword;
            $favorite->save();
            return redirect('/twitter/keywords/favorites')->with('flash_message', __('Registerd'));
        } else {
            $user_id = Auth::id();
            $screen_names = DB::table('twitter_accounts')->where('user_id', '=', $user_id)->pluck('screen_name');
            return view('twitter.favorites', ['screen_names' => $screen_names]);
        }
    }
}

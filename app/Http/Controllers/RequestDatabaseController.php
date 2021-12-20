<?php

namespace App\Http\Controllers;

use App\Services\RateLimitStatusService;
use App\Target;
use App\TwitterAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class RequestDatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function accounts()
    {
        $user_id = Auth::id();
        return DB::table('twitter_accounts')->where('user_id', '=', $user_id)->get()->toJson();
    }

    public function keywords(Request $request)
    {
        $account_id = $request->input('id');
        return DB::table('follow_keywords')->where('account_id', '=', $account_id)->get()->toJson();
    }

    public function favoriteKeywords(Request $request)
    {
        $account_id = $request->input('id');
        return DB::table('favorites')->where('account_id', '=', $account_id)->get()->toJson();
    }

    public function tweets(Request $request)
    {
        $account_id = $request->input('id');
        return DB::table('tweets')->where('account_id', '=', $account_id)->get()->toJson();
    }

    public function name()
    {
        $id = Auth::id();
        return DB::table('users')->where('id', '=', $id)->value('name');
    }

    public function email()
    {
        $id = Auth::id();
        return DB::table('users')->where('id', '=', $id)->value('email');
    }

    public function targets(Request $request)
    {
        $account_id = $request->input('id');
        return DB::table('targets')->where('account_id', '=', $account_id)->get()->toJson();
    }

}

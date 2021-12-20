<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;
use Illuminate\Support\Facades\DB;

class TargetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('twitter.targets');
    }

    public function create(Request $request)
    {
        //２個以上キーワード登録ができないように、データの数を取得して、１個データが入っていると登録できないようにしている
        $account_id = $request->account_id;
//        $data = DB::table('targets')->where('account_id', '=',$account_id)->count();
//        if($data < 1) {
            $request->validate([
                'target_name' => 'required | string | max:255'
            ]);
            $target = new Target;
            $target->account_id = $request->account_id;
            $target->target_name = $request->target_name;
            $target->save();
            return redirect('/twitter/targets')->with('flash_message', '登録しました');
//        } else {
//            return redirect('/twitter/targets')->with('flash_message','登録できませんでした。登録済みのものを削除してください');
//        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'target_name' => 'required | string | max:255'
        ]);
        $account_id = $request->account_id;
        $id = DB::table('targets')->where('account_id','=', $account_id)->value('id');
        $target = Target::find($id);
        $target ->fill($request->all())->save();
        return redirect('/twitter/targets')->with('flash_message', '更新しました');

    }

    public function destroy(Request $request)
    {
        $account_id = $request->account_id;
        $id = $request->target_id;
        Target::where('account_id',$account_id)->where('id',$id)->delete();
        return redirect('/twitter/targets')->with('flash_message', '削除しました');

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home.profile');
    }

    //ToDo バリデーションの箇所、このままだと同じ内容を登録することはできるが、他者のemailを登録しようとするとDB側でエラーがでて別ページにはじかれる。方法を考えないといけない。
    public function edit(Request $request)
    {
        $request -> validate([
            'name' => 'required | string| max:255',
            'email' => 'string | email | max:255 '
        ]);
        $id = Auth::id();
        $user = User::find($id);
        $user -> fill($request->all())->save();
        return redirect('/profile')->with('flash_message','更新しました');
    }

    //ToDo 退会処理を論理削除できるようにする。
    public function withdraw()
    {
        $id = Auth::id();
        User::where('id',$id)->delete();
        Auth::logout();
        return redirect('/')->with('flash_message','退会しました');
    }

}

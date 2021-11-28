<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $user = Auth::user();
        return view('home.mypage',['name'=>$user['name'],'email'=>$user['email']]);
    }

    //ToDo バリデーションの箇所、このままだと同じ内容を登録することはできるが、他者のemailを登録しようとするとDB側でエラーがでて別ページにはじかれる。方法を考えないといけない。
    public function edit(Request $request)
    {
    $request -> validate([
        'name' => 'required | string| max:255',
        'email' => 'string | email | max:255 '
    ]);
        $user = Auth::user();
        $user -> fill($request->all())->save();
        return redirect('/home')->with('flash_message',__('Registered.'));
    }

    public function withdraw()
    {
        return view('home.mypage');
    }

}

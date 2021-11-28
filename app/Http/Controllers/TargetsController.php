<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TargetsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view ('twitter.targets');
    }

    public function create(Request $request)
    {
//        $request -> validate ([
//            'favorite_keyword'=>'required | string | max:255'
//        ]);
//        $favorite = new Favorite;
//        $favorite->fill($request->all())->save();
//        return redirect('/keywords/favorites')->with('flash_message',__('Registerd'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;
use App\Mail\SendDayMail;
use App\Mail\SendFinishedMail;
use App\Mail\SendSuspendedMail;
use App\Mail\SendTweetMail;

use Illuminate\Support\Facades\Log;

class MailSendController extends Controller
{


    public function minuteslimit()
    {

        $data = [];

        $id = Auth::id();
        $to = DB::table('users')->where('id',$id)->value('email');

        Log::debug(print_r($to,true));

        Mail::to($to)->send(new SendMail());

    }

    public function daylimit()
    {

        $data = [];

        $id = Auth::id();
        $to = DB::table('users')->where('id',$id)->value('email');

        Log::debug(print_r($to,true));

        Mail::to($to)->send(new SendDayMail());
    }

    public function finished()
    {

        $data = [];

        $id = Auth::id();
        $to = DB::table('users')->where('id',$id)->value('email');

        Log::debug(print_r($to,true));

        Mail::to($to)->send(new SendFinishedMail());
    }

    public function suspended()
    {

        $data = [];

        $id = Auth::id();
        $to = DB::table('users')->where('id',$id)->value('email');

        Log::debug(print_r($to,true));

        Mail::to($to)->send(new SendSuspendedMail());
    }

    public function tweet()
    {

        $data = [];

        $id = Auth::id();
        $to = DB::table('users')->where('id',$id)->value('email');

        Log::debug(print_r($to,true));

        Mail::to($to)->send(new SendTweetMail());
    }
}

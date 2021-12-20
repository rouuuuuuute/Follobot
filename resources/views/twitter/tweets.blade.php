@extends('layouts.app')

@section('content')

    <div id="js-tweets">
        <tweets :csrf="{{ json_encode(csrf_token())}}"></tweets>
    </div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection

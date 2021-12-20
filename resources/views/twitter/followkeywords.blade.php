@extends('layouts.app')

@section('content')

    <div id="js-follow_keywords">
        <follow-keywords :csrf="{{ json_encode(csrf_token())}}"></follow-keywords>
    </div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection

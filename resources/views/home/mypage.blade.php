@extends('layouts.app')

@section('content')
    <div id="js-home">
        <home :csrf="{{ json_encode(csrf_token())}}"></home>
    </div>
@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection







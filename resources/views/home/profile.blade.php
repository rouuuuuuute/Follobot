@extends('layouts.app')

@section('content')

    <div id="js-profile">
        <profile :csrf="{{ json_encode(csrf_token())}}"></profile>
    </div>
@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection







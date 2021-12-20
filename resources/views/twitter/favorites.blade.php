@extends('layouts.app')


@section('content')

    <div id="js-favorites">
        <favorites :csrf="{{ json_encode(csrf_token())}}"></favorites>
    </div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection

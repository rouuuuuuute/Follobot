@extends('layouts.app')

@section('content')

    <div id="js-targets">
        <targets :csrf="{{ json_encode(csrf_token())}}"></targets>
    </div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection

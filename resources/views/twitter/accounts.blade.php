@extends('layouts.app')


@section('content')

<div id="js-accounts">
    <accounts :csrf="{{ json_encode(csrf_token())}}"></accounts>
</div>

@endsection

@section('sidebar')
    <div id="js-sidebar">
        <sidebar></sidebar>
    </div>
@endsection




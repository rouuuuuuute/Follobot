@extends('layouts.app')

{{--ToDo 各ボタンごとにアカウント登録できるようにすること。また、登録したアカウント名が表示されるようにすること。--}}
{{--ToDo アカウントが重複した場合、エラーが出せるようにすること。--}}

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




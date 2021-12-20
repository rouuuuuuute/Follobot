@extends('layouts.app')

{{--ToDo 要件にはないが、次回までに実装させたいもの jsでのバリデーション、多言語対応、入力値の保持--}}

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

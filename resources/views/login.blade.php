@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

    <h1>ログイン</h1>

    <form action="{{route('login')}}" method="post">
        @csrf

        <div class="label">ユーザー名</div>
        <input type="text" name="name">

        <div class="label">パスワード</div>
        <input type="password" name="password">

        <button type="submit">ログイン</button>
    </form>

@endsection
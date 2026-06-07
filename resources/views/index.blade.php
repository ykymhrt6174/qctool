@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <div class="menu-grid">

        <a href="{{ route('inspection') }}" class="menu-card">
            <h2>未完了検査</h2>
        </a>

        <a href="{{ route('trend.input') }}" class="menu-card">
            <h2>傾向確認</h2>
        </a>

    </div>

</div>

@endsection
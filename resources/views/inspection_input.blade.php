@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/inspection_input.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <h1>結果入力</h1>

    <form action="{{ route('inspection.update', $inspection->id) }}" method="post">
        @csrf
        <div>製品名：{{ $inspection->production->name }}</div>
        <div>ロット：{{ \Carbon\Carbon::parse($inspection->production_date)->format('ymd') }}</div>

        <div class="measurement">
            <input type="number" name="measurement" value="{{ old('measurement')}}">
            <span>mm</span>
        </div>
        @error('measurement')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">登録</button>
</form>

</div>

@endsection
@extends('layout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/trend_input.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <h1>傾向確認（検索条件）</h1>

    <form action="{{ route('trend') }}" method="GET">

        <div class="form-row">
            <label>製品名:</label>

            <select name="production_id">
                <option value="">選択してください</option>

                @foreach($productions as $production)
                    <option value="{{ $production->id }}"
                        {{ request('production_id') == $production->id ? 'selected' : '' }}>
                        {{ $production->name }}
                    </option>
                @endforeach
            </select>

            @error('production_id')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row">
            <label>生産日:</label>

            <div class="date-range">
                <input type="date" name="from_date" value="{{ request('from_date') }}">
                <span>〜</span>
                <input type="date" name="to_date" value="{{ request('to_date') }}">
            </div>

            @if ($errors->has('to_date'))
                <span class="error">{{ $errors->first('to_date') }}</span>
            @elseif ($errors->has('from_date'))
                <span class="error">{{ $errors->first('from_date') }}</span>
            @endif
        </div>

        <div class="button-area">
            <button type="submit">検索</button>
        </div>

        <div>※2026/5/1～2026/5/15の検査結果がサンプルデータとして登録されています</div>
    </form>

</div>

@endsection
@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/inspection_create.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <h1>検査対象追加</h1>

<form action="{{ route('inspection.store') }}" method="post">
    @csrf

    <div class="form-row">
        <label>製品名</label>

        <select name="production_id">
            <option value="">選択してください</option>

            @foreach($productions as $production)
                <option value="{{ $production->id }}"
                    {{ old('production_id') == $production->id ? 'selected' : '' }}>
                    {{ $production->name }}
                </option>
            @endforeach
        </select>

        @error('production_id')
            <span class="error">製品名を入力してください</span>
        @enderror
    </div>

    <div class="form-row">
        <label>生産日</label>

        <input type="date" name="production_date" value="{{ old('production_date') }}">

        @error('production_date')
            <span class="error">生産日を入力してください</span>
        @enderror
    </div>

    <div class="form-row">
        <label>出荷日</label>

        <input type="date" name="shipment_date" value="{{ old('shipment_date') }}">

        @error('shipment_date')
            <span class="error">出荷日を入力してください</span>
        @enderror
    </div>

    <button type="submit">登録</button>
</form>

</div>

@endsection
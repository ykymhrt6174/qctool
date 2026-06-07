@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/inspection.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <h1>未完了検査</h1>

    <a href="{{ route('inspection.create') }}" class="add-btn">
        ＋ 試験対象を追加
    </a>

    <div class="tab-area">
        <a
            href="{{ route('inspection', ['sort' => 'production']) }}"
            class="{{ $sort === 'production' ? 'active' : '' }}"
        >
            生産日順
        </a>

        <a
            href="{{ route('inspection', ['sort' => 'shipment']) }}"
            class="{{ $sort === 'shipment' ? 'active' : '' }}"
        >
            出荷日順
        </a>
    </div>

    <table class="inspection-table">
        <thead>
            <tr>
                <th>製品名</th>
                <th>ロット</th>
                <th>出荷日</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach($inspections as $inspection)
                <tr>
                    <td>
                        {{ $inspection->production->name }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($inspection->production_date)->format('ymd') }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($inspection->shipment_date)->format('m/d') }}
                    </td>

                    <td>
                        <a
                            href="{{ route('inspection.input', $inspection->id) }}"
                            class="inspection-btn"
                        >
                            検査
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
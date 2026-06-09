@extends('layout')

@section('css')
<link rel="stylesheet" href="{{ asset('css/trend.css') }}">
@endsection

@section('content')

<div class="menu-page">

    <h1>検査結果の傾向</h1>

    <div class="trend-summary">

        <div class="col">

            <div class="row">
                <div class="label">参照データ数</div>
                <div class="value">{{ $count }}</div>
            </div>

            <div class="row">
                <div class="label">指定製品</div>
                <div class="value">{{ $production->name ?? '-' }}</div>
            </div>

            <div class="row">
                <div class="label">指定期間</div>
                <div class="value">{{ request('from_date') }} ～ {{ request('to_date') }}</div>
            </div>

        </div>

        <div class="col">
            <div class="row">
                <div class="label">平均値</div>
                <div class="value">{{ number_format($avg, 3) }}</div>
            </div>

            <div class="row">
                <div class="label">最小値</div>
                <div class="value">{{ $min }}</div>
            </div>

            <div class="row">
                <div class="label">最大値</div>
                <div class="value">{{ $max }}</div>
            </div>

            <div class="row">
                <div class="label">UCL / LCL</div>
                <div class="value">
                    {{ $count >= 3 ? number_format($ucl, 3) . ' / ' . number_format($lcl, 3) : 'データ不足のため非表示' }}
                </div>
            </div>

        </div>

    </div>

    {{-- Chart --}}
    <div style="height:400px;">
        <canvas id="trendChart"></canvas>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
window.addEventListener('DOMContentLoaded', () => {

    const labels = @json($labels ?? []);
    const values = @json($values ?? []);

    const avg = Number(@json($avg ?? 0));
    const sigma = Number(@json($sigma ?? 0));

    const count = Number(@json($count ?? 0));

    console.log({ labels, values, avg, sigma, count });

    if (!labels.length || !values.length) return;

    const datasets = [

        {
            label: '検査結果',
            data: values,
            borderColor: 'black',
            backgroundColor: 'black',
            pointRadius: 3,
            tension: 0
        }

    ];

    // ===== データが3件以上なら管理限界線を追加 =====
    if (count >= 3) {

        const upper = Number(@json($ucl ?? 0));
        const lower = Number(@json($lcl ?? 0));

        datasets.push(
            {
                label: '平均値',
                data: Array(values.length).fill(avg),
                borderColor: 'skyblue',
                borderDash: [5, 5],
                pointRadius: 0,
                tension: 0
            },
            {
                label: 'UCL',
                data: Array(values.length).fill(upper),
                borderColor: 'green',
                borderDash: [5, 5],
                pointRadius: 0,
                tension: 0
            },
            {
                label: 'LCL',
                data: Array(values.length).fill(lower),
                borderColor: 'green',
                borderDash: [5, 5],
                pointRadius: 0,
                tension: 0
            }
        );
    }

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels,
            datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: { display: true, text: '生産日' }
                },
                y: {
                    title: { display: true, text: '検査結果 (mm)' }
                }
            }
        }
    });

});
</script>

@endsection
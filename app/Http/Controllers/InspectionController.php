<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\Production;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    public function inspection(Request $request)
    {
        $sort = $request->input('sort', 'production');

        $column = $sort === 'shipment'
            ? 'shipment_date'
            : 'production_date';

        $inspections = Inspection::with('production')
            ->whereNull('measurement')
            ->orderBy($column)
            ->get();

        return view('inspection', compact('inspections', 'sort'));
    }

    public function create()
    {
        $productions = Production::all();

        return view('inspection_create', compact('productions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'production_id' => ['required', 'exists:productions,id'],
            'production_date' => ['required'],
            'shipment_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'production_id.required' => '製品名を入力してください。',
            'production_id.exists' => '製品名を入力してください。',

            'production_date.required' => '生産日を入力してください。',

            'shipment_date.after_or_equal' => '出荷日は今日以降の日付を入力してください。',
            'shipment_date.required' => '出荷日を入力してください。',
        ]);

        Inspection::create([
            'production_id' => $request->production_id,
            'production_date' => $request->production_date,
            'shipment_date' => $request->shipment_date
        ]);

        return redirect()
            ->route('inspection');
    }

    public function show(Inspection $inspection)
    {
        return view('inspection_input', compact('inspection'));
    }

    public function update(Request $request, Inspection $inspection)
    {
        $inspection->update([
            'measurement' => $request->measurement,
            'inspection_date' => now(),
        ]);

        return redirect()
            ->route('inspection')
            ->with('success', '登録しました');
    }

    public function trend_input()
    {
        $productions = Production::all();

        return view('trend_input', compact('productions'));
    }

    public function trend(Request $request)
    {
        $request->validate([
            'production_id' => ['required', 'exists:productions,id'],
            'from_date' => ['required'],
            'to_date' => ['required', 'after_or_equal:from_date'],
            ],
            [
            'production_id.required' => '製品名を入力してください。',
            'production_id.exists' => '製品名を入力してください。',
            'from_date.required' => '生産日を入力してください',
            'to_date.required' => '生産日を入力してください',
            'to_date.after_or_equal' => '終了日は開始日以降を入力してください。',
        ]);

        $production = Production::find($request->production_id);
        $query = Inspection::query()
            ->whereNotNull('measurement');

        if ($request->production_id) {
            $query->where('production_id', $request->production_id);
        }

        if ($request->from_date) {
            $query->whereDate('production_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('production_date', '<=', $request->to_date);
        }

        $data = $query->orderBy('production_date')->get();

        $values = $data->pluck('measurement');
        $labels = $data->pluck('production_date');

        $avg = $values->avg();
        $count = $values->count();
        $sigma = $count > 0
            ? sqrt($values->reduce(function ($carry, $v) use ($avg) {
                return $carry + pow($v - $avg, 2);
            }, 0) / $count - 1)
            : 0;

        $min = $values->min();
        $max = $values->max();

        $count = $values->count();

        $ucl = $avg + (3 * $sigma);
        $lcl = $avg - (3 * $sigma);

        return view('trend', compact(
            'data',
            'values',
            'labels',
            'avg',
            'sigma',
            'min',
            'max',
            'count',
            'ucl',
            'lcl',
            'production'
        ));
    }
}

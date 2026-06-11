<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InspectionController;


Route::get('/', function () {return view('index');})->name('dashboard');


Route::get('/inspection', [InspectionController::class, 'inspection'])->name('inspection');
Route::get('/inspection/create', [InspectionController::class, 'create'])->name('inspection.create');
Route::post('/inspection/store', [InspectionController::class, 'store'])->name('inspection.store');

Route::get('/inspection/{inspection}', [InspectionController::class, 'show'])->name('inspection.input');
Route::post('/inspection/{inspection}', [InspectionController::class, 'update'])->name('inspection.update');

Route::get('/trendinput', [InspectionController::class, 'trend_input'])->name('trend.input');
Route::get('/trend', [InspectionController::class, 'trend'])->name('trend');

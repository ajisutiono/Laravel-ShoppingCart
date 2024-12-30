<?php

use App\Livewire\Product\Index;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/product', Index::class)
    ->middleware('auth')
    ->name('admin.product');
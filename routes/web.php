<?php

use App\Livewire\Product\Index;
use App\Livewire\Shop\Index as ShopIndex;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin/product', Index::class)
    ->middleware('auth')
    ->name('admin.product');

Route::get('/shop', ShopIndex::class)
    ->name('shop.index');
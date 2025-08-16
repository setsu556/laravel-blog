<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// ブログ一覧画面を表示
Route::get('/', [BlogController::class, 'showList'])->name('blogs');

// ブログ登録画面を表示
Route::get('/blog/create', [BlogController::class, 'showCreate'])->name('create');

// ブログ登録
Route::post('/blog/store', [BlogController::class, 'exeStore'])->name('store');

// ブログ詳細画面を表示
Route::get('/blog/{id}', [BlogController::class, 'showDetail'])->name('show');

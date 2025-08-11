<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// ブログ一覧画面を表示
Route::get('/', [BlogController::class, 'showList'])->name('blogs');

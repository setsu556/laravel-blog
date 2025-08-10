<?php

use Illuminate\Support\Facades\Route;

// ブログ一覧画面を表示
Route::get('/', 'BlogController@showList')->name('blogs');

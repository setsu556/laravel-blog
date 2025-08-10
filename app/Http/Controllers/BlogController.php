<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * ブログ一覧を表示する
     *
     * @return View
     */
    public function showList(): View
    {
        return view('blog.list');
    }
}

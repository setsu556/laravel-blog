<?php

namespace App\Http\Controllers;

use App\Models\Blog;
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
        $blogs = Blog::all();
        return view('blog.list', ['blogs' => $blogs]);
    }
}

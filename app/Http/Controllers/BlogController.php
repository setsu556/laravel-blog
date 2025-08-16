<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

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

    /**
     * ブログ詳細を表示する
     *
     * @param $id
     * @return RedirectResponse|View
     */
    public function showDetail($id): View|RedirectResponse
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.detail', ['blog' => $blog]);
    }

    /**
     * ブログ登録画面を表示する
     * @return View
     */
    public function showCreate(): View
    {
        return view('blog.form');
    }

    /**
     * ブログを登録する
     *
     * @param BlogRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function exeStore(BlogRequest $request): Application|Redirector|RedirectResponse
    {
        // リクエストのデータを受け取る
        $inputs = $request->all();

        DB::beginTransaction();
        try {
            // ブログを登録
            Blog::create($inputs);
            DB::commit();
        } catch (Throwable) {
            DB::rollBack();
            abort(500);
        }


        Session::flash('err_msg', 'ブログを登録しました。');
        return redirect(route('blogs'));
    }
}

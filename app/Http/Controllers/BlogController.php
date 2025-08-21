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
        $blogs = Blog::orderBy('id')->get();
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
     * ブログ編集画面を表示する
     *
     * @param $id
     * @return RedirectResponse|View
     */
    public function showEdit($id): View|RedirectResponse
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        return view('blog.edit', ['blog' => $blog]);
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

        try {
            DB::transaction(function () use ($inputs) {
                // ブログを登録
                Blog::create($inputs);
            });
        } catch (Throwable) {
            abort(500);
        }


        Session::flash('err_msg', 'ブログを登録しました。');
        return redirect(route('blogs'));
    }

    /**
     * ブログを更新する
     *
     * @param BlogRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function exeUpdate(BlogRequest $request): Application|Redirector|RedirectResponse
    {
        // リクエストのデータを受け取る
        $inputs = $request->all();

        try {
            DB::transaction(function () use ($inputs) {
                // ブログを更新
                $blog = Blog::find($inputs['id']);
                $blog->fill([
                    'title' => $inputs['title'],
                    'content' => $inputs['content'],
                ]);
                $blog->save();
            });
        } catch (Throwable) {
            abort(500);
        }


        Session::flash('err_msg', 'ブログを更新しました。');
        return redirect(route('blogs'));
    }

    /**
     * ブログ編集削除
     *
     * @param $id
     * @return RedirectResponse|View
     */
    public function exeDelete($id): View|RedirectResponse
    {
        if (is_null($id)) {
            Session::flash('err_msg', 'データがありません。');
            return redirect(route('blogs'));
        }

        try {
            Blog::destroy($id);
        } catch (Throwable) {
            abort(500);
        }

        Session::flash('err_msg', 'ブログを削除しました。');
        return redirect(route('blogs'));
    }
}

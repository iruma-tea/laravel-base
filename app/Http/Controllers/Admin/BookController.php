<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use App\Http\Requests\BookPutRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BookController extends Controller
{
    // indexアクション
    public function index(): Response
    {
        // 書籍一覧を取得
        $books = Book::with('category')->orderBy('category_id')->orderBy('title')->get();

        // 書籍一覧をレスポンスとして返す
        return response()->view('admin.book.index', ['books' => $books])->header('Content-Type', 'text/html')->header('Content-Encoding', 'UTF-8');
    }

    // showアクション
    public function show(Book $book): View
    {
        Log::info('書籍詳細情報が参照されました。ID=' . $book->id);

        // 取得した書籍をレスポンスとして返す
        return view('admin.book.show', compact('book'));
    }

    // createアクション
    public function create(): View
    {
        // BookPolicyのcreateメソッドによる認可
        $this->authorize('create', Book::class);

        // カテゴリ一覧
        $categories = Category::all();

        // 著者一覧
        $authors = Author::all();

        return view('admin.book.create', compact('categories', 'authors'));
    }

    // storeアクション
    public function store(BookPostRequest $request): RedirectResponse
    {
        // BookPolicyのcreateメソッドによる認可
        $this->authorize('create', Book::class);

        // 書籍データ登録用のオブジェクトを生成する
        $book = new Book();

        // リクエストオブジェクトからパラメータを取得
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;
        $book->admin_id = Auth::id();

        DB::transaction(function () use ($book, $request) {
            // 保存
            $book->save();

            // 著者書籍テーブルを登録
            $book->authors()->attach($request->author_ids);
        });

        // book.indexにリダイレクトする
        return redirect(route('book.index'))->with('message', $book->title . 'を追加しました。');
    }

    // editアクション
    public function edit(Book $book): View
    {
        // 作成者以外はアクセス不可
        // if (Auth::user()->cannot('update', $book)) {
        //     abort(403);
        // }
        $this->authorize('update', $book);

        // カテゴリ一覧の取得
        $categories = Category::all();

        // 著者一覧の取得
        $authors = Author::all();

        // 書籍に紐づく著者IDの取得
        $authorIds = $book->authors()->pluck('id')->all();

        return view('admin.book.edit', compact('book', 'categories', 'authors', 'authorIds'));
    }

    // updateアクション
    public function update(BookPutRequest $request, Book $book): RedirectResponse
    {
        // 作成者以外はアクセス不可
        $this->authorize('update', $book);

        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        DB::transaction(function () use ($book, $request) {
            // 更新
            $book->update();

            // 書籍と著者の関連付けを更新
            $book->authors()->sync($request->author_ids);
        });

        return redirect(route('book.index'))->with('message', $book->title . 'を更新しました。');
    }

    // destroy
    public function destroy(Book $book): RedirectResponse
    {
        // 作成者以外はアクセス不可
        $this->authorize('update', $book);
        // 削除(カスケード機能による子テーブルの削除)
        $book->delete();
        return redirect(route('book.index'))->with('message', $book->title . 'を削除しました。');
    }
}

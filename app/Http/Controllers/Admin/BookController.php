<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        // 取得した書籍をレスポンスとして返す
        return view('admin.book.show', compact('book'));
    }

    // createアクション
    public function create(): View
    {
        // カテゴリ一覧
        $categories = Category::all();

        // 著者一覧
        $authors = Author::all();

        return view('admin.book.create', compact('categories', 'authors'));
    }

    // storeアクション
    public function store(BookPostRequest $request): RedirectResponse
    {
        // 書籍データ登録用のオブジェクトを生成する
        $book = new Book();

        // リクエストオブジェクトからパラメータを取得
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

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
        // カテゴリ一覧の取得
        $categories = Category::all();

        // 著者一覧の取得
        $authors = Author::all();

        // 書籍に紐づく著者IDの取得
        $authorIds = $book->authors()->pluck('id')->all();

        return view('admin.book.edit', compact('book', 'categories', 'authors', 'authorIds'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function show(string $id): View
    {
        // 書籍を1件取得
        $book = Book::findOrFail($id);

        // 取得した書籍をレスポンスとして返す
        return view('admin.book.show', compact('book'));
    }

    // createアクション
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.book.create', [
            'categories' => $categories,
        ]);
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

        // 保存
        $book->save();

        // book.indexにリダイレクトする
        return redirect(route('book.index'))->with('message', $book->title . 'を追加しました。');
    }
}

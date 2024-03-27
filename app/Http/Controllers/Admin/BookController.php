<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    // indexアクション
    public function index(): Collection
    {
        // 書籍一覧を取得
        $books = Book::all();

        // 書籍一覧をレスポンスとして返す
        return $books;
    }

    // showアクション
    public function show(string $id): Book
    {
        // 書籍を1件取得
        $book = Book::findOrFail($id);

        // 取得した書籍をレスポンスとして返す
        return $book;
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
    public function store(Request $request): Book
    {
        // 書籍データ登録用のオブジェクトを生成する
        $book = new Book();

        // リクエストオブジェクトからパラメータを取得
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        // 保存
        $book->save();

        // 保存した書籍情報をレスポンスとして返す。
        return $book;
    }
}

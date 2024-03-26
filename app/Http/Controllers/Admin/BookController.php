<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
}

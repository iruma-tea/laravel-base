<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $books = Book::all();
        $authors = Author::all();

        foreach ($books as $book) {
            $authorIds = $authors->random(2)->pluck('id')->all(); // 2件の著者をランダムに抽出。著者モデルからIDのみを抽出
            $book->authors()->attach($authorIds);
        }
    }
}

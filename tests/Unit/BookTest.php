<?php

namespace Tests\Unit;

use App\Models\Book;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    // public function test_example(): void
    // {
    //     $this->assertTrue(true);
    // }

    /** @test */
    public function 書籍のタイトルが11文字で省略される(): void
    {
        // $book1 = new Book();
        // $book1->title = 'PHPer Book'; // 10文字
        $book1 = Book::factory()->make(['title' => 'PHPer Book']);
        $this->assertSame('PHPer Book', $book1->abbreviatedTitle());

        // $book2 = new Book();
        // $book2->title = 'PHPer Book2'; // 11文字
        $book2 = Book::factory()->make(['title' => 'PHPer Book2']);
        $this->assertSame('PHPer Book...', $book2->abbreviatedTitle());
    }
}

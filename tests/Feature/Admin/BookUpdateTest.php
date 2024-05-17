<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    use RefreshDatabase;

    private $admin;
    private $categories;
    private $book;
    private $authors;

    public function setUp(): void
    {
        parent::setUp();

        // ログインユーザーの作成
        $this->admin = Admin::factory()->create([
            'login_id' => 'hoge',
            'password' => Hash::make('hogehoge'),
        ]);

        // カテゴリ3件、作成
        $this->categories = Category::factory(3)->create();

        // 更新対象の書籍1件作成
        $this->book = Book::factory()->create([
            'title' => 'Laravel Book',
            'admin_id' => $this->admin->id,
            'category_id' => $this->categories[1]->id,
        ]);

        // 著者4件作成
        $this->authors = Author::factory(4)->create();

        // 著者4件中2件を書籍に関連付け
        $this->book->authors()->attach([
            $this->authors[0]->id,
            $this->authors[2]->id,
        ]);
    }

    /** @test */
    public function 画面のアクセス制御(): void
    {
        $url = route('book.edit', $this->book);

        // 未認証の場合、更新画面にアクセス不可
        $this->get($url)->assertRedirect(route('admin.create'));

        // 書籍の作成者とは異なるユーザーで認証
        $other = Admin::factory()->create();
        $this->actingAs($other, 'admin');

        // 書籍の作成者でない場合、更新画面にアクセス不可
        $this->get($url)->assertForbidden(); // 403

        // 作成者で認証
        $this->actingAs($this->admin, 'admin');

        // 書籍の作成者の場合、更新画面にアクセス可
        $this->get($url)->assertOk();
    }
}

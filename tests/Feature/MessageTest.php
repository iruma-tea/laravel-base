<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    /** @test */
    public function メッセージ一覧の表示(): void
    {
        // メッセージ一覧にリクエストを送信
        // $response = $this->get('messages');
        // // 200(OK)が返る。
        // $response->assertOk();

        // 事前情報としてメッセージ作成
        Message::create(['body' => 'Hello World']);
        Message::create(['body' => 'Hello Laravel']);

        print_r(Message::all());

        // メッセージ一覧にHello World、Hello Laravelが表示される
        // $this->get('messages')->assertOk()->assertSee('Hello World')->assertSee('Hello Laravel');
        $this->get('messages')->assertOk()->assertSeeInOrder(['Hello World', 'Hello Laravel']); // 出力順の検証はassertSeeInOrderメソッドで検証
    }
}

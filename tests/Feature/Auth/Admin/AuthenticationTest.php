<?php

namespace Tests\Feature\Auth\Admin;

use App\Models\Admin;
use Database\Factories\AdminFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
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

    public function setUp(): void
    {
        // 親のsetUpメソッド呼び出し(必須)
        parent::setUp();

        // ログインテスト用ユーザー作成
        $this->admin = Admin::factory()->create([
            'login_id' => 'hoge',
            'password' => Hash::make('hogehoge'),
        ]);
    }

    /** @test */
    public function ログイン画面の表示(): void
    {
        $this->get(route('admin.create'))->assertOk();
    }

    /** @test */
    public function ログイン成功(): void
    {
        // 1. ログイン用ユーザー作成
        // $admin = Admin::factory()->create([
        //     'login_id' => 'hoge',
        //     'password' => Hash::make('hogehoge'),
        // ]);

        // 2. ログインが成功すると書籍一覧にリダイレクトする
        $this->post(route('admin.store'), [
            'login_id' => 'hoge',
            'password' => 'hogehoge',
        ])->assertRedirect(route('book.index'));

        // 3. 認証されている
        // $this->assertAuthenticatedAs($admin, 'admin');
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    /** @test */
    public function ログイン失敗()
    {
        // 1. 事前情報としてログイン用ユーザー作成
        // $admin = Admin::Factory()->create([
        //     'login_id' => 'hoge',
        //     'password' => Hash::make('hogehoge'),
        // ]);

        // 2. IDが一致しない場合
        $this->from(route('admin.store'))->post(route('admin.store'), [
            'login_id' => 'fuga',
            'password' => 'hogehoge',
        ])->assertRedirect(route('admin.create'))->assertInvalid(['login_id' => 'auth failed']);

        // パスワードが一致しない
        $this->from(route('admin.store'))->post(route('admin.store'), [
            'login_id' => 'hoge',
            'password' => 'fugafuga',
        ])->assertRedirect(route('admin.create'))->assertInvalid(['login_id' => 'auth failed']);

        // 認証されない
        $this->assertGuest('admin');
    }

    /** @test */
    public function バリデーション(): void
    {
        $url = route('admin.store');

        // リダイレクト
        $this->from(route('admin.create'))->post($url, [
            'login_id' => ''
        ])->assertRedirect(route('admin.create'));

        // ID未入力
        $this->post($url, ['login_id' => ''])->assertInvalid(['login_id' => 'login id は必須']);

        // ID入力
        $this->post($url, ['login_id' => 'a'])->assertValid('login_id');

        // パスワード未入力
        $this->post($url, ['password' => ''])->assertInvalid(['password' => 'password は必須']);

        // パスワード入力
        $this->post($url, ['password' => 'a'])->assertValid('passowrd');
    }
}

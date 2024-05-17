<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageController extends Controller
{
    // indexアクション
    public function index(): View
    {
        $messages = Message::orderBy('id')->get();
        // messagesとういうキーでビューに渡す
        return view('message/index', [
            'messages' => $messages
        ]);
    }

    // storeアクション
    public function store(Request $request): RedirectResponse
    {
        $message = new Message();
        $message->body = $request->body;
        $message->save();

        return redirect('/messages');
    }

    public function destroy(string $id): RedirectResponse
    {
        // 削除処理
        // DB::delete('delete from messages where id = ' . $id);
        DB::delete('delete from messages where id = ?', [$id]);
        return redirect('/messages');
    }
}

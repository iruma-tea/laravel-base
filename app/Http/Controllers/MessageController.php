<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    // indexアクション
    public function index(): View
    {
        $messages = Message::all();
        // messagesとういうキーでビューに渡す
        return view('message/index', [
            'messages' => $messages
        ]);
    }
}

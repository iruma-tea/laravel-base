<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    // public function index(): Collection
    public function index(): AnonymousResourceCollection
    {
        $messages = Message::all();

        // return $messages;
        return MessageResource::collection($messages);
    }

    // public function show(Message $message): Message
    public function show(Message $message): MessageResource
    {
        // return $message;
        return new MessageResource($message);
    }

    public function store(Request $request): Message
    {
        $message = new Message();
        $message->body = $request->body;
        $message->save();

        return $message;
    }

    public function destroy(Message $message): Response
    {
        $message->delete();

        // HTTPステータスコード204(コンテンツなし)を返す
        return response()->noContent();
    }
}

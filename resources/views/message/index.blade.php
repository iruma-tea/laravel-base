<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Message Sample</title>
</head>
<body>
    <main>
        <h1>メッセージ</h1>
        <form action="/messages" method="post">
            @csrf
            <input type="text" name="body" id="body">
            <input type="submit" value="投稿">
        </form>
        <hr>
        <ul>
            @foreach ($messages as $message)
                {{-- <li>{{$message->body}}</li> --}}
                {{-- 以下、脆弱性のあるコード(XSS) --}}
                {{-- <li>{!! $message->body !!}</li> --}}
                {{-- <a href="{{$message->body}}">{{$message->body}}</a> --}}
                <li>
                    {{-- {{ $message->body }}/<a href="/messages/{{ $message->id }}/delete">削除</a> --}}
                    <form action="/messages/{{ $message->id }}/delete" method="POST">
                        {{ $message->body }}
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="削除">
                    </form>
                </li>
            @endforeach
        </ul>
    </main>
</body>
</html>

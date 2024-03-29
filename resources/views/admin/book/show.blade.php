<x-layouts.book-manager>
    <x-slot:title>
        書籍詳細
    </x-slot:title>
    <ul>
        <li>ID：{{$book->id}}</li>
        <li>カテゴリ：{{$book->category->title}}</li>
        <li>タイトル：{{$book->title}}</li>
        <li>著者：
            <ul>
                @foreach ($book->authors as $author)
                    <li>{{$author->name}}</li>
                @endforeach
            </ul>
        </li>
    </ul>
    <a href="{{route('book.index')}}">戻る</a>
</x-layouts.book-manager>

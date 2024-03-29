<x-layouts.book-manager>
    <x-slot:title>
        書籍一覧
    </x-slot:title>
    <h1>書籍一覧</h1>
    @if (session('message'))
        <div style="color:blue">
            {{session('message')}}
        </div>
    @endif
    <a href="{{route('book.create')}}">追加</a>
    <x-book-table :$books />
</x-layouts.book-manager>

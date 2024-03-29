<x-layouts.book-manager>
    <x-slot:title>
        書籍登録
    </x-slot:title>

    <h1>書籍登録</h1>
    @if ($errors->any())
        <x-alert>
            <x-error-messages :errors="$errors" />
        </x-alert>
    @endif
    <form action="{{route('book.store')}}" method="post">
        @csrf
        <div>
            <label for="category_id">カテゴリ</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @selected($category->id == old('category_id'))>
                        {{$category->title}}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" value="{{old('title')}}">
        </div>
        <div>
            <label for="price">価格</label>
            <input type="text" name="price" id="price" value="{{old('price')}}">
        </div>
        <input type="submit" value="送信">
    </form>
</x-layouts.book-manager>

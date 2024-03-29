<div>
    <label>カテゴリ</label>
    <select name="category_id" id="category_id">
        @foreach ($categories as $category)
            <option value="{{$category->id}}" @selected($category->id == old('catebory_id', $book->category_id))>
                {{$category->title}}
            </option>
        @endforeach
    </select>
</div>
<div>
    <label>タイトル</label>
    <input type="text" name="title" id="title" value="{{old('title', $book->title)}}">
</div>
<div>
    <label>価格</label>
    <input type="text" name="price" id="price" value="{{old('price', $book->price)}}">
</div>
<div>
    <label>著者</label>
    <ul>
        @foreach ($authors as $author)
            <li>
                <input type="checkbox" name="author_ids[]" id="author_ids" value="{{$author->id}}" @checked(in_array($author->id, old('author_ids', $authorIds)))>
                {{$author->name}}
            </li>
        @endforeach
    </ul>
</div>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>書籍登録</title>
</head>
<body>
    <main>
        <h1>書籍登録</h1>
        <form action="/admin/books" method="post">
            @csrf
            <div>
                <label for="category_id">カテゴリ</label>
                <select name="category_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">
                            {{$category->title}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title">
            </div>
            <div>
                <label for="price">価格</label>
                <input type="text" name="price" id="price">
            </div>
            <input type="submit" value="送信">
        </form>
    </main>
</body>
</html>

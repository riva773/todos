@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}"/>
@endsection

@section('content')
<div class="todo__alert">
    @if(session('message'))
    <div class="todo__alert--success">
        {{ session('message') }}
        {{--
             セッションに格納されている値は、session('キー')で取り出せる
        --}}
    </div>
    @endif
    @if($errors->any())
    <div class="todo__alert--danger">
        <ul>
           @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
           @endforeach
        </ul>
    </div>
    @endif
    {{--
        @if($errors->any())は、バリデーションエラーが起きた場合、$errorsに自動でエラー情報が入る。かつ、any()メソッドは、配列の中に1つでも要素があるかを調べるメソッド。
    --}}
     {{--
        foreach文はforeach(配列 as 変数)の形で使用するもの。$errorsは、ViewErrorBagクラスのインスタンスなので、配列ではなく、foreach($errors as $error)とはできない。
        そのため、allメソッドのようなコレクションを配列に変えるメソッドを使用する。
    --}}

</div>
        {{-- BEM記法は、Block,Element,Modifierの略称で、
        Blockは.headerや.button,
        Elementは、header__logo,button__icon,
        Modifierは、button--primary,button--disabledなど 
        --}}

<div class="todo__content">
    <div class="section__title">
        <h2>新規作成</h2>
    </div>
    <form action="/todos" method="post" class="create-form">
    @csrf
        <div class="create-form__item">
            <input class="create-form__item-input" type="text" name="content" value="{{ old('content')}} ">
            {{--
                name属性がないと何の値なのかを判別できないため、フォームを送信しても値が送られない
            --}}
            <select class="create-form__item-select" name="category_id">
                {{--
                    name属性を付与しないと、postメソッドで送ってもrequestオブジェクトに選択した値が含まれず、意味がなくなる。
                    選択しているのはカテゴリなので、どのカテゴリかを明確にする必要があり、それを明確にするカラムはcategory_idカラムなので,name属性はcategory_idに指定する
                --}}
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                {{--
                    optionタグは<option value="送信したい値">表示したい値</option>の形で記述するので上記の形になる。
                    idを送信することでどのカテゴリを送信したかがわかる
                --}}
                @endforeach
            </select>
            {{--
                selectタグはプルダウンメニューを作るタグ
                optionタグはselectタグの中で選択肢を作るタグ
                optionタグのvalueは何も洗濯していない時の値
                optionタグで囲っている要素は実際に画面に表示される選択肢のテキスト
            --}}
        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
        {{--
            <input type="button" value="作成" class="todo__button">ではなく、
            button type = "submit"を使用する
            input type="button"には、送信機能がないので、単なる見た目上のボタンにしかならないため。
        --}}
    </form>
        <div class="section__title">
            <h2>Todo検索</h2>
        </div>
    <form class="search-form">
        <div class="search-form__item">
            <input type="text" class="search-form__item-input" name="content" value="{{ old('content')}} ">
            <select class="search-form__item-select" name="category_id">
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__button">
            <button class="search-form__button-submit" type="submit">検索</button>
        </div>
    </form>

    <div class="todo-table">
        <table class="todo-table__inner">
            <tr class="todo-table__row">
                <th class="todo-table__header">
                    <span class="todo-table__header-span">Todo</span>
                    <span class="todo-table__header-span">カテゴリ</span>
                </th>
            </tr>
            @foreach ($todos as $todo)
            <tr class="todo-table__row">
                <td class="todo-table__item">
                    <form action="/todos/update" class="update-form" method="POST">
                        @method('PATCH')
                        @csrf
                        {{--
                            更新や削除処理はHTMLでは直接指定できないので、method="post"にしつつ、@method('PATCH')などおん@methodディレクティブを使用する
                        --}}
                        <div class="update-form__item">
                            <input class="update-form__item-input" type="text" name="content" value="{{ $todo['content'] }}">
                            </input>
                            <input type="hidden" name="id" value=" {{ $todo['id'] }}">
                            {{--
                                更新処理や削除処理の時は、テーブル内のどのデータを更新、削除するのか識別するためにinputのtype="hidden"で、name="id",value="{{$変数['キー']}}"に指定して、idを渡すことが多い。
                            --}}
                        </div>
                        <div class="update-form__item">
                            <p class="update-form__item-p">{{ $todo['category']['name'] }}</p>
                            {{--
                            indexアクションでは、$categoryは定義されていないが、$todoで定義されており、Todoモデルにcategoryメソッドでリレーションが組まれているので、$todo['category']['name']でカテゴリー名が取得できる
                            --}}
                        </div>
                        <div class="update-form__button">
                            <button class="update-form__button-submit" type="submit">更新</button>
                        </div>
                    </form>
                </td>
                <td class="todo-table__item">
                    <form action="/todos/delete" class="delete-form" method= "POST">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection


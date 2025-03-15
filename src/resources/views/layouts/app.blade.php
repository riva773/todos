<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
     <div class="header-utilities">
        <a class="header__logo" href="/">
          Todo
        </a>
       <nav>
         <ul class="header-nav">
           <li class="header-nav__item">
             <a class="header-nav__link" href="/categories">カテゴリ一覧</a>
           </li>
         </ul>
       </nav>
     </div>
    </div>
  </header>
  <main>
    @yield('content')
  </main>
</body>

</html>



{{--
navタグって何だ
    ナビゲーションは、サイト内の各ページを移動するためのメニューやリンク。
    そのサイトの案内。
    上記をnavタグで囲う。

なんでulとli使ってんだ？
    ヘッダーのナビゲーションにはulとliを使うもの。
    navタグからのulとliで、その後にaタグの形がテンプレっぽいらしい

なんでheader-utilitiesで囲ったんだ？display:flexのspace-betweenするためか？
    そう

header__utilitiesは、ヘッダーの中の補助的な要素(ユーティリティ)をまとめるという意味で名付けられている(役にたつなどの意味)
--}}
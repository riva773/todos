<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
// todosテーブルにデータを保存、取得するために、Todoモデルを読み込む必要がある
use App\Models\Category;
// indexアクションでCategory::all()しているので、Categoryモデルを読み込む必要がある
use App\Http\Requests\TodoRequest;
// バリデーションとエラーメッセージを定義したTodoRequestを読み込む必要がある

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::with('category')->get();
        // withメソッドで、リレーションのあるデータを取得し、N+1問題も解決できる
        // 引数の'category'は、Todoモデルに定義されているcategoryメソッドの名前で、このメソッドでリレーションを定義しているので、それを文字列の形で引数に渡すらしい
        // getメソッドを実行するまでデータを取得してはいない(クエリを実行してデータを取得するメソッド)
        $categories = Category::all();
        // セレクトボタンでカテゴリを選ぶ箇所があるので、全てのカテゴリを取得してviewに渡す必要がある
        return view('index', compact('todos', 'categories'));
        // return view('index', [ "todos" => $todos, "categories" => $categories ]);でもOK
    }

    public function store(TodoRequest $request){
        $todo = $request->only(['content', 'category_id']);
        Todo::create($todo);
        return redirect('/')->with('message', 'Todoを作成しました');
        // return redirect('/')ならindexメソッドが再度呼び出されるので、新しいデータが反映される。
        // return view('/')ではなく、redirectの理由は、return viewだとビューファイルの読み込みになるので、indexアクションが起きず、新しいデータが読み込まれない可能性があるため。;
        // redirect('/')->with('キー', 'value')の形で、'/'のパスにリダイレクトした時に一度だけ使用できるデータをセッションに保存する
        // TodoRequestに設定したバリデーションやエラーメッセージを使用するために、Request型ではなく、TodoRequest型の引数を受け取る
    }

    public function update(TodoRequest $request) {
        //$request内のcontentを取得する
        $todo = $request->only(['content']);
        //  $todo = $request->content;ではなく、
        //  $todo = $request->only(['content']);なのは、$request->contentとすると、contentの値だけ、onlyメソッドを使用するとそれをキーとする連想配列ごと配列の形で抜き出せる。updateメソッドやcreateメソッドは、キーとバリューのセットでてきようするものなので、onlyメソッドを使用する。ちなみにonly()内を[]でくくっているのは、複数のキーのデータを一度に取得できる仕様だから。
        
         //どのTodoか識別する
         Todo::find($request->id)->update($todo);
        //  リダイレクトしてメッセージを送る
        return redirect('/')->with('message', 'Todoを更新しました');
    }

    public function destroy(Request $request){
        // バリデーションを使用しないので、TodoRequestではなく、Requestを使用する
        // idを取得
        Todo::find($request->id)->delete();
        return redirect('/')->with('message','Todoを削除しました');
        // $requestは、Requestクラスのオブジェクトなので、配列のように$request['id']ではなく、$request->idとして、値を取得する
    }

    public function search(Request $request){
        $todos = Todo::with('category')->CategorySearch($request->category_id)->KeywordSearch($request->keyword)->get();
        $categories = Category::all();
        return view('index', compact('todos', 'categories'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('/category', compact('categories'));
    }

    public function store(CategoryRequest $request){
        // $requestのnameキーとその値を格納する
        $category = $request->only(['name']);
        // モデルに保存
        Category::create($category);
        // リダイレクトする
        return redirect('/categories')->with('message', 'カテゴリを作成しました');
    }
    public function update(CategoryRequest $request){
        // 更新後の値を配列の形で取得
        $category = $request->only(['name']);
        //findメソッドでどのレコードかを決める
        Category::find($request->id)->update($category);
        // $requestはオブジェクトなので、プロパティの値にアクセスするには->を使用する。['']を使用するのは配列の時のみ
        return redirect('/categories')->with('messages', 'カテゴリを更新しました');
    }

    public function destroy(Request $request) {
        Category::find($request->id)->delete();
        return redirect('/categories')->with('message','カテゴリを削除しました');
    }

}

// Requestオブジェクトのonlyメソッドは、指定したキーの配列または連想配列を返す。
// $category = $request->only(['name']);なら、$categoryには、['name' => '値']が入る
// ->は、PHPでオブジェクトのメソッドを使用する時にオブジェクト->メソッド();として、書く
// onlyメソッドは配列を作るために[]でくくっている。
// ('')でくくる理由は、配列のキー名は''で囲う必要があるため。("")でもOK。

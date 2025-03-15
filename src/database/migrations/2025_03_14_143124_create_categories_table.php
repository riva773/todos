<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',10)->unique();
            $table->timestamps();
        });
        // Laravel では テーブルの制約（データベースレベル）とバリデーション（アプリケーションレベル）の両方を設定するのが一般的なので、テーブル作成時のマイグレーションファイルにも制約を記述する。
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}

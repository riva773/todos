<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function scopeCategorySearch($query, $category_id){
        if(!empty($category_id)){
            $query->where('category_id',$category_id);
        }
    }
    // $category_idが、空でなければ、$queryから'category_id'カラムが$category_idの値のものを検索する
    // スコープメソッドの$queryは、自動でEloquentから渡されるため、呼び出し時に描かなくていい

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)){
            $query->where('content','like','%' . $keyword . '%');
        }
    }
    // $keywordが空でなければ$queryの中から、'content'カラムが$keywordを含むものを検索する
}

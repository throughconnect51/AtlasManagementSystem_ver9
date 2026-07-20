<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function likes(){
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
    }

    public function subCategories(){
        return $this->belongsToMany(
            'App\Models\Categories\SubCategory', // 紐付ける相手のモデル
            'post_sub_categories',               // 中間テーブルの名前
            'post_id',                           // 中間テーブル内での自モデルのID
            'sub_category_id'                    // 中間テーブル内での相手モデルのID
        );
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
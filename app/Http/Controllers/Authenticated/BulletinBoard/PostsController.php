<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        // メインカテゴリー取得時に紐づくサブカテゴリーも一緒にロードしておく
        $categories = MainCategory::with('subCategories')->get();
        $like = new Like;
        $post_comment = new Post;

        // キーワード検索（部分一致&サブカテゴリー完全一致）
        if (!empty($request->keyword)) {
                $keyword = $request->keyword;

            // 入力されたキーワードがサブカテゴリー名と完全一致するか確認
            $subCategoryExists = SubCategory::where('sub_category', $keyword)->first();

            if ($subCategoryExists) {
                // 完全一致するサブカテゴリーが存在する場合、そのカテゴリーに属する投稿のみ取得
                $posts = Post::with('user', 'postComments')
                    ->where('post_category_id', $subCategoryExists->id)
                    ->get();
            } else {
                // 一致しない場合は、通常のタイトル・本文の部分一致検索
                $posts = Post::with('user', 'postComments')
                    ->where('post_title', 'like', '%'.$keyword.'%')
                    ->orWhere('post', 'like', '%'.$keyword.'%')
                    ->get();
            }
        }
        // サブカテゴリーをクリックした時の検索（完全一致）
        else if (!empty($request->category_word)) {
            $sub_category_name = $request->category_word;

            $posts = Post::with('user', 'postComments')
                ->whereHas('subCategories', function($q) use ($sub_category_name) {
                $q->where('sub_category', $sub_category_name);
            })->get();
        }

        // いいねした投稿の絞り込み
        else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        }
        // 自分の投稿の絞り込み
        else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $post->subCategories()->attach($request->post_category_id);

        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    
    public function mainCategoryCreate(Request $request){
        $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ], [
            'main_category_name.required' => 'メインカテゴリーは必ず入力してください。',
            'main_category_name.string'   => 'メインカテゴリーは文字列である必要があります。',
            'main_category_name.max'      => 'メインカテゴリーは100文字以内で入力してください。',
            'main_category_name.unique'   => 'このメインカテゴリーは既に登録されています。',
        ]);

        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        $request->validate([
            'comment' => 'required|string|max:250',
        ], [
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.string'   => 'コメントは文字列である必要があります。',
            'comment.max'      => 'コメントは250文字以内で入力してください。',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function subCategoryCreate(Request $request){
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ], [
            'main_category_id.required'  => 'メインカテゴリーを選択してください。',
            'main_category_id.exists'    => '登録されているメインカテゴリーを選択してください。',
            'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。',
            'sub_category_name.string'   => 'サブカテゴリーは文字列である必要があります。',
            'sub_category_name.max'      => 'サブカテゴリーは100文字以内で入力してください。',
            'sub_category_name.unique'   => 'このサブカテゴリーは既に登録されています。',
        ]);

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name,
        ]);
        return redirect()->route('post.input');
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }
}
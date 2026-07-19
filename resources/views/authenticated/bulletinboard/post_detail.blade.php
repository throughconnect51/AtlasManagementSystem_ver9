<x-sidebar>
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">
      <div class="p-3">
        
        <!-- バリデーションエラーメッセージの表示エリア -->
        @if ($errors->any())
          <div class="alert alert-danger p-2 mb-3" style="border: 1px solid #f5c6cb; background-color: #f8d7da; border-radius: 4px;">
            <ul class="mb-0" style="list-style: none; padding-left: 0;">
              @foreach ($errors->all() as $error)
                <li class="error_message" style="color: #721c24; font-size: 13px; font-weight: bold;">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="detail_inner_head">
          <div></div>
          <div>
            <!-- 自分の投稿の場合のみ「編集」「削除」ボタンを表示 -->
            @if($post->user_id == Auth::id())
              <span class="edit-modal-open btn btn-primary btn-sm" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}" style="cursor: pointer;">編集</span>
              <!-- aタグでの直接遷移を廃止し、削除確認モーダルを開くボタンに変更 -->
              <span class="delete-modal-open btn btn-danger btn-sm ml-2" post_id="{{ $post->id }}" style="cursor: pointer;">削除</span>
            @endif
          </div>
        </div>

        <div class="contributor d-flex">
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
      </div>
      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>
          @foreach($post->postComments as $comment)
          <div class="comment_area border-top">
            <p>
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <p>{{ $comment->comment }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="w-50 p-3">
    <div class="comment_container border m-5">
      <div class="comment_area p-3">
        <p class="m-0">コメントする</p>
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>

<!-- ==================== 1. 投稿編集用モーダル ==================== -->
<div class="modal js-modal" id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
  <div class="modal__bg js-modal-close" style="position: absolute; width: 100%; height: 100%;"></div>
  <div class="modal__content" style="background: #fff; padding: 30px; border-radius: 8px; width: 500px; position: relative; z-index: 1001; margin: auto;">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-100 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100 modal-title-input">
        </div>
        <div class="modal-inner-body w-100 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100 modal-body-textarea" rows="8"></textarea>
        </div>
        <div class="w-100 m-auto edit-modal-btn d-flex justify-content-between">
          <button type="button" class="js-modal-close btn btn-danger">閉じる</button>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

<!-- ==================== 2. 投稿削除用モーダル ==================== -->
<div class="modal js-delete-modal" id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
  <div class="modal__bg js-delete-modal-close" style="position: absolute; width: 100%; height: 100%;"></div>
  <div class="modal__content" style="background: #fff; padding: 30px; border-radius: 8px; width: 400px; position: relative; z-index: 1001; margin: auto;">
    <div class="p-3 text-center">
      <p class="mb-4" style="font-weight: bold; color: #333;">この投稿を削除してもよろしいですか？</p>
    </div>
    <div class="d-flex justify-content-between px-3">
      <button type="button" class="btn btn-secondary js-delete-modal-close">閉じる</button>
      <!-- 削除実行用のフォーム -->
      <form action="" method="post" id="deletePostForm" style="margin: 0;">
        @csrf
        <input type="submit" class="btn btn-danger" value="削除">
      </form>
    </div>
  </div>
</div>

<!-- bulletin.js を読み込み（もしメインレイアウト側で読み込み済みであれば省略可ですが、ここにあれば確実に動作します） -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/bulletin.js') }}"></script>
</x-sidebar>
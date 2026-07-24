<x-sidebar>
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container">
      <div class="p-3">
        
        @error('post_title')
          <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 8px; font-weight: bold;">{{ $message }}</span>
        @enderror

        <div class="detail_inner_head d-flex justify-content-between align-items-center mb-2">
          <div>
            @foreach($post->subCategories as $subCategory)
              <a href="{{ route('post.show', ['category_word' => $subCategory->sub_category]) }}" class="badge badge-info text-white px-3 py-1 text-decoration-none" style="border-radius: 20px; font-size: 0.75rem; font-weight: normal; background-color: #00B5D8;">
                {{ $subCategory->sub_category }}
              </a>
            @endforeach
          </div>

          <div>
            <!-- 自分の投稿の場合のみ「編集」「削除」ボタンを表示 -->
            @if($post->user_id == Auth::id())
              <span class="edit-modal-open btn btn-primary btn-sm" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}" style="cursor: pointer;">編集</span>
              <span class="delete-modal-open btn btn-danger btn-sm ml-2" post_id="{{ $post->id }}" style="cursor: pointer;">削除</span>
            @endif
          </div>
        </div>

        <!-- 投稿者情報 -->
        <div class="contributor d-flex text-secondary small mb-2">
          <p class="m-0">
            <span>{{ $post->user->over_name }}</span>
            <span class="ml-1">{{ $post->user->under_name }}</span>
            さん
          </p>
          <span class="ml-4">{{ $post->created_at }}</span>
        </div>

        <!-- 投稿タイトル -->
        <div class="detsail_post_title font-weight-bold" style="font-size: 1.1rem;">{{ $post->post_title }}</div>

        <!-- 投稿本文 -->
        <div class="mt-3 detsail_post" style="white-space: pre-wrap; font-size: 0.95rem;">{{ $post->post }}</div>
      </div>

      <!-- コメント一覧表示エリア -->
      <div class="p-3">
        <div class="comment_container">
          <span class="text-secondary small font-weight-bold">コメント</span>
          @foreach($post->postComments as $comment)
          <div class="comment_area border-top pt-2 mt-2">
            <p class="mb-1 text-secondary small">
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span class="ml-1">{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <p class="m-0" style="font-size: 0.9rem;">{{ $comment->comment }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  
  <!-- コメント投稿エリア -->
  <div class="w-50 p-3">
    @error('comment')
      <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin: 20px 0 -15px 48px; font-weight: bold;">{{ $message }}</span>
    @enderror

    <div class="comment_container border m-5 p-3 bg-white rounded shadow-sm">
      <div class="comment_area">
        <p class="mb-2 font-weight-bold text-secondary" style="font-size: 0.9rem;">コメントする</p>
        <textarea class="w-100 form-control mb-3" name="comment" form="commentRequest" rows="5"></textarea>
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        
        <div class="text-right">
          <input type="submit" class="btn btn-primary text-white px-4" form="commentRequest" value="投稿" style="background-color: #00B5D8; border: none;">
        </div>
        
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>

<!-- ====================  投稿編集用モーダル ==================== -->
<div class="modal js-modal" id="editModal">
  <div class="modal__bg js-modal-close"></div>
  
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-100 m-auto">
          @error('post_title')
            <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px; font-weight: bold;">{{ $message }}</span>
          @enderror
          <input type="text" name="post_title" placeholder="タイトル" class="w-100 modal-title-input form-control">
        </div>
        
        <div class="modal-inner-body w-100 m-auto pt-3 pb-3">
          @error('post_body')
            <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px; font-weight: bold;">{{ $message }}</span>
          @enderror
          <textarea placeholder="投稿内容" name="post_body" class="w-100 modal-body-textarea form-control" rows="8"></textarea>
        </div>
        
        <div class="w-100 m-auto d-flex justify-content-between">
          <button type="button" class="js-modal-close btn btn-secondary">閉じる</button>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

<!-- ==================== 投稿削除用モーダル ==================== -->
<div class="modal js-delete-modal" id="deleteModal">
  <div class="modal__bg js-delete-modal-close"></div>
  
  <div class="modal__content" style="max-width: 450px;">
    <div class="p-3 text-center">
      <p class="mb-4" style="font-weight: bold; color: #333;">この投稿を削除してもよろしいですか？</p>
    </div>
    <div class="d-flex justify-content-between px-3">
      <button type="button" class="btn btn-secondary js-delete-modal-close">閉じる</button>
      <form action="" method="post" id="deletePostForm" style="margin: 0;">
        @csrf
        <input type="submit" class="btn btn-danger" value="削除">
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/bulletin.js') }}"></script>
</x-sidebar>
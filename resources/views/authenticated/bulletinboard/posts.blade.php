<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <!-- 投稿一覧表示エリア -->
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3 bg-white rounded shadow-sm mb-3">
      <!-- 投稿者と日付 -->
      <p class="text-secondary small mb-1">
        <span>{{ $post->user->over_name }}</span><span class="ml-1">{{ $post->user->under_name }}</span>さん
      </p>

      <!-- 投稿タイトル -->
      <p class="font-weight-bold mb-2" style="font-size: 1.1rem;">
        <a href="{{ route('post.detail', ['id' => $post->id]) }}" class="text-dark">{{ $post->post_title }}</a>
      </p>

      <div class="mb-2">
        @foreach($post->subCategories as $subCategory)
          <button type="submit" name="category_word" value="{{ $subCategory->sub_category }}" form="postSearchRequest" class="badge badge-info text-white px-3 py-1 border-0" style="border-radius: 20px; font-size: 0.75rem; font-weight: normal; background-color: #00B5D8; cursor: pointer;">
          {{ $subCategory->sub_category }}
          </button>
        @endforeach
      </div>

      <div class="post_bottom_area d-flex justify-content-end align-items-center mt-3">
        <!-- コメント数 & いいね数 -->
        <div class="d-flex post_status align-items-center">
          <!-- コメント数表示 -->
          <div class="mr-3 text-secondary">
            <i class="fa fa-comment mr-1"></i>
            <span class="small font-weight-bold">{{ $post->postComments->count() }}</span>
          </div>
          <!-- いいね表示-->
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0 text-danger">
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }} ml-1 font-weight-bold small">{{ $post->likes()->count() }}</span>
            </p>
            @else
            <p class="m-0 text-secondary">
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
              <span class="like_counts{{ $post->id }} ml-1 font-weight-bold small">{{ $post->likes()->count() }}</span>
            </p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- 検索・カテゴリー操作エリア -->
  <div class="other_area border w-25 bg-light p-3">
    <div class="border p-3 bg-white rounded shadow-sm">
      <div class="mb-3"><a href="{{ route('post.input') }}" class="btn btn-info btn-block text-white" style="background-color: #00B5D8; border: none;">投稿</a></div>
      <div class="d-flex mb-3">
        <input type="text" class="form-control form-control-sm mr-1" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="btn btn-info btn-sm text-white" value="検索" form="postSearchRequest" style="background-color: #00B5D8; border: none;">
      </div>
      <div class="d-flex justify-content-between mb-3">
        <input type="submit" name="like_posts" class="btn btn-sm text-white w-50 mr-1" value="いいねした投稿" form="postSearchRequest" style="font-size: 0.75rem; background-color: #F6AD55; border: none;">
        <input type="submit" name="my_posts" class="btn btn-sm text-white w-50" value="自分の投稿" form="postSearchRequest" style="font-size: 0.75rem; background-color: #ECC94B; border: none;">
      </div>

      <!-- カテゴリー一覧表示エリア -->
      <p class="mt-4 mb-2 font-weight-bold text-secondary" style="font-size: 0.95rem;">カテゴリー検索</p>
      <ul style="padding-left: 0; list-style: none;">
        @foreach($categories as $category)
        <li style="margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
          <!-- メインカテゴリー表示（矢印アイコン付き） -->
          <div class="main_category_toggle d-flex justify-content-between align-items-center" style="cursor: pointer; font-weight: bold; color: #4A5568;">
            <span>{{ $category->main_category }}</span>
            <i class="fas fa-chevron-down arrow-icon" style="font-size: 0.8rem; color: #A0AEC0; transition: transform 0.2s;"></i>
          </div>

          <!-- サブカテゴリーリスト -->
          <ul class="sub_category_list" style="padding-left: 10px; list-style: none; margin-top: 5px; display: none;">
            @foreach($category->subCategories as $sub_category)
            <li style="border-bottom: 1px solid #f0f0f0; padding: 4px 0;">
              <button type="submit" name="category_word" value="{{ $sub_category->sub_category }}" form="postSearchRequest" style="background: none; border: none; padding: 0; color: #4A5568; text-decoration: none; cursor: pointer; font-size: 0.85rem; text-align: left; width: 100%;">
                {{ $sub_category->sub_category }}
              </button>
            </li>
            @endforeach
          </ul>
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- 検索・絞り込みリクエスト送信用フォーム -->
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function() {
    // メインカテゴリークリック時のアコーディオン開閉と矢印の回転アニメーション
    $('.main_category_toggle').on('click', function() {
      $(this).next('.sub_category_list').slideToggle(200);
      $(this).find('.arrow-icon').toggleClass('open');
    });
  });
</script>

</x-sidebar>
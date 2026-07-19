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
      <p class="font-weight-bold" style="font-size: 1.1rem;">
        <a href="{{ route('post.detail', ['id' => $post->id]) }}" class="text-primary">{{ $post->post_title }}</a>
      </p>
      
      <div class="post_bottom_area d-flex justify-content-between align-items-center mt-3">
        <!-- サブカテゴリーバッジの表示 -->
        <div>
          @if($post->subCategory)
            <span class="badge badge-secondary px-2 py-1 text-muted" style="background-color: #ddd; border-radius: 4px; font-size: 0.8rem;">
              {{ $post->subCategory->sub_category }}
            </span>
          @endif
        </div>

        <!-- コメント数 & いいね数 -->
        <div class="d-flex post_status align-items-center">
          <!-- コメント数表示 -->
          <div class="mr-3 text-secondary">
            <i class="fa fa-comment mr-1"></i>
            <span class="small font-weight-bold">{{ $post->postComments->count() }}</span>
          </div>
          <!-- いいね表示 -->
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0 text-danger"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }} ml-1 font-weight-bold small"></span></p>
            @else
            <p class="m-0 text-secondary"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }} ml-1 font-weight-bold small"></span></p>
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
      <div class="mb-3"><a href="{{ route('post.input') }}" class="btn btn-info btn-block text-white">投稿</a></div>
      <div class="d-flex mb-3">
        <input type="text" class="form-control form-control-sm mr-1" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="btn btn-primary btn-sm" value="検索" form="postSearchRequest">
      </div>
      <div class="d-flex justify-content-between mb-3">
        <input type="submit" name="like_posts" class="btn btn-warning btn-sm text-white w-50 mr-1" value="いいねした投稿" form="postSearchRequest" style="font-size: 0.75rem;">
        <input type="submit" name="my_posts" class="btn btn-success btn-sm text-white w-50" value="自分の投稿" form="postSearchRequest" style="font-size: 0.75rem;">
      </div>
      
      <!-- カテゴリー一覧表示エリア（アコーディオン構造） -->
      <p class="mt-4 mb-2 font-weight-bold text-secondary" style="font-size: 0.95rem;">カテゴリー</p>
      <ul style="padding-left: 0; list-style: none;">
        @foreach($categories as $category)
        <li style="margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
          <!-- メインカテゴリー表示（クリックで開閉させるためのクラス付き） -->
          <div class="main_category_toggle" style="cursor: pointer; font-weight: bold; color: #333; display: flex; justify-content: space-between; align-items: center;">
            <span>{{ $category->main_category }}</span>
            <span class="arrow-icon" style="font-size: 0.8rem; color: #999;">▼</span>
          </div>
          
          <!-- 初期状態は非表示（style="display: none;"）にするサブカテゴリーリスト -->
          <ul class="sub_category_list" style="padding-left: 15px; list-style: none; margin-top: 5px; display: none;">
            @foreach($category->subCategories as $sub_category)
            <li class="mt-1">
              <button type="submit" name="category_word" value="{{ $sub_category->sub_category }}" form="postSearchRequest" style="background: none; border: none; padding: 2px 0; color: #007bff; text-decoration: none; cursor: pointer; font-size: 0.85rem; text-align: left; width: 100%;">
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

<!-- jQuery を用いたアコーディオン開閉用のスクリプト記述 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function() {
    $('.main_category_toggle').on('click', function() {
      // クリックされたメインカテゴリーの直後にあるサブカテゴリーリストを開閉
      $(this).next('.sub_category_list').slideToggle(200);
      
      // 矢印の向きを変更（お好みで）
      var arrow = $(this).find('.arrow-icon');
      if (arrow.text() === '▼') {
        arrow.text('▲');
      } else {
        arrow.text('▼');
      }
    });
  });
</script>
</x-sidebar>
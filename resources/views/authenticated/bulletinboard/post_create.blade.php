<x-sidebar>
<div class="post_create_container d-flex">
  <!-- 左側：新規投稿エリア -->
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      @if($errors->first('post_category_id'))
      <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('post_category_id') }}</span>
      @endif
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        <option value="">---</option>
        @foreach($main_categories as $main_category)
          <!-- メインカテゴリーの見出し（グレー文字） -->
          <optgroup label="{{ $main_category->main_category }}" style="color: #999; font-weight: bold;">
            <!-- サブカテゴリーの選択肢（黒文字） -->
            @foreach($main_category->subCategories as $sub_category)
              <option value="{{ $sub_category->id }}" {{ old('post_category_id') == $sub_category->id ? 'selected' : '' }} style="color: #333;">
                {{ $sub_category->sub_category }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>

  <!-- 右側：カテゴリー追加エリア（講師アカウントのみ表示） -->
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <!-- メインカテゴリー追加 -->
      <div class="">
        @if($errors->first('main_category_name'))
        <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('main_category_name') }}</span>
        @endif
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest" value="{{ old('main_category_name') }}">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-1" form="mainCategoryRequest">
      </div>
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>

      <!-- サブカテゴリー追加 -->
      <div class="mt-4">
        @if($errors->first('main_category_id'))
        <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('main_category_id') }}</span>
        @endif
        @if($errors->first('sub_category_name'))
        <span class="error_message" style="color: red; display: block; font-size: 0.8rem; margin-bottom: 4px;">{{ $errors->first('sub_category_name') }}</span>
        @endif
        <p class="m-0">メインカテゴリー選択</p>
        <select class="w-100" name="main_category_id" form="subCategoryRequest">
          <option value="">---</option>
          @foreach($main_categories as $main_category)
            <option value="{{ $main_category->id }}" {{ old('main_category_id') == $main_category->id ? 'selected' : '' }}>{{ $main_category->main_category }}</option>
          @endforeach
        </select>

        <p class="m-0 mt-2">サブカテゴリー</p>
        <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest" value="{{ old('sub_category_name') }}">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-1" form="subCategoryRequest">
      </div>
      <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
    </div>
  </div>
  @endcan
</div>
</x-sidebar>
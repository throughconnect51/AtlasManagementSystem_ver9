<x-sidebar>
<div class="post_create_container d-flex flex-column">

  @if ($errors->any())
  <div class="alert alert-danger w-75 mx-auto mt-4 p-3 bg-danger text-white rounded shadow-sm">
    <ul class="mb-0" style="list-style: none; padding-left: 0; font-size: 0.9rem;">
      @foreach ($errors->all() as $error)
      <li>・{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="d-flex w-100">
    <!-- 左側：新規投稿エリア -->
    <div class="post_create_area border w-50 m-5 p-5 bg-white rounded shadow-sm">
      <div class="">
        <p class="mb-0">カテゴリー</p>
        <select class="w-100" form="postCreate" name="post_category_id">
          <option value="">---</option>
          @foreach($main_categories as $main_category)
            <optgroup label="{{ $main_category->main_category }}" style="color: #999; font-weight: bold;">
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
        <p class="mb-0">タイトル</p>
        <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
      </div>

      <div class="mt-3">
        <p class="mb-0">投稿内容</p>
        <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
      </div>

      <div class="mt-3 text-right">
        <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
      </div>
      <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
    </div>

    <!-- カテゴリー追加エリア（講師アカウントのみ表示） -->
    @can('admin')
    <div class="w-25 ml-auto mr-auto">
      <div class="category_area mt-5 p-5 bg-white border rounded shadow-sm">
        <!-- メインカテゴリー追加 -->
        <div class="">
          <p class="m-0">メインカテゴリー</p>
          <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest" value="{{ old('main_category_name') }}">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0 mt-1" form="mainCategoryRequest">
        </div>
        <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>

        <!-- サブカテゴリー追加 -->
        <div class="mt-4">
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
</div>
</x-sidebar>
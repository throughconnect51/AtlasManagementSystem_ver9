<x-sidebar>
<div class="p-4 w-100 container-fluid all_content">
  <p class="top_title mb-3">ユーザー検索</p>
  
  <div class="search_content w-100 d-flex justify-content-between align-items-start">
    
    <!-- ユーザー一覧エリア -->
    <div class="reserve_users_area w-75 d-flex flex-wrap align-content-start gap-3">
      @foreach($users as $user)
      <div class="one_person p-3">
        <div class="user_card_item">
          <span class="text-muted small">ID : </span><span>{{ $user->id }}</span>
        </div>
        <div class="user_card_item">
          <span class="text-muted small">名前 : </span>
          <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="font-weight-bold">
            <span>{{ $user->over_name }}</span>
            <span>{{ $user->under_name }}</span>
          </a>
        </div>
        <div class="user_card_item">
          <span class="text-muted small">カナ : </span>
          <span class="text-secondary">({{ $user->over_name_kana }}</span>
          <span class="text-secondary">{{ $user->under_name_kana }})</span>
        </div>
        <div class="user_card_item">
          <span class="text-muted small">性別 : </span>
          @if($user->sex == 1)<span>男</span>
          @elseif($user->sex == 2)<span>女</span>
          @else<span>その他</span>
          @endif
        </div>
        <div class="user_card_item">
          <span class="text-muted small">生年月日 : </span><span>{{ $user->birth_day }}</span>
        </div>
        <div class="user_card_item">
          <span class="text-muted small">権限 : </span>
          @if($user->role == 1)<span>教師(国語)</span>
          @elseif($user->role == 2)<span>教師(数学)</span>
          @elseif($user->role == 3)<span>講師(英語)</span>
          @else<span>生徒</span>
          @endif
        </div>
        <div class="user_card_item">
          @if($user->role == 4)
          <span class="text-muted small">選択科目 : </span>
            @foreach($user->subjects as $subject)
              <span class="badge badge-light border text-secondary">{{ $subject->subject }}</span>
            @endforeach
          @endif
        </div>
      </div>
      @endforeach
    </div>

    <!-- 検索条件サイドバー -->
    <div class="search_area w-25 p-3 ml-4">
      <div class="search_box_inner">
        <p class="search_side_title">検索</p>
        
        <!-- キーワード入力 -->
        <div class="form-group mb-3">
          <input type="text" class="form-control free_word bg-light border-0" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
        </div>
        
        <!-- カテゴリ選択 -->
        <div class="form-group mb-3">
          <label class="small font-weight-bold text-secondary mb-1">カテゴリ</label>
          <select form="userSearchRequest" name="category" class="form-control custom-select bg-light border-0">
            <option value="name">名前</option>
            <option value="id">社員ID</option>
          </select>
        </div>
        
        <!-- 並び替え -->
        <div class="form-group mb-4">
          <label class="small font-weight-bold text-secondary mb-1">並び替え</label>
          <select name="updown" form="userSearchRequest" class="form-control custom-select bg-light border-0">
            <option value="ASC">昇順</option>
            <option value="DESC">降順</option>
          </select>
        </div>
        
        <div class="search_conditions_wrapper border-top pt-3 mb-4">
          <p class="m-0 search_conditions d-flex justify-content-between align-items-center small font-weight-bold text-secondary">
            <span>検索条件の追加</span>
            <i class="fas fa-chevron-down arrow-icon"></i>
          </p>
          
          <div class="search_conditions_inner p-3 mt-2 rounded">
            <!-- 性別 -->
            <div class="mb-3">
              <label class="small font-weight-bold d-block mb-1">性別</label>
              <div class="form-check form-check-inline mr-2">
                <input class="form-check-input" type="radio" name="sex" value="1" form="userSearchRequest" id="sex_male">
                <label class="form-check-label small" for="sex_male">男</label>
              </div>
              <div class="form-check form-check-inline mr-2">
                <input class="form-check-input" type="radio" name="sex" value="2" form="userSearchRequest" id="sex_female">
                <label class="form-check-label small" for="sex_female">女</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sex" value="3" form="userSearchRequest" id="sex_other">
                <label class="form-check-label small" for="sex_other">その他</label>
              </div>
            </div>
            
            <!-- 権限 -->
            <div class="mb-3">
              <label class="small font-weight-bold d-block mb-1">権限</label>
              <select name="role" form="userSearchRequest" class="form-control custom-select form-control-sm bg-light border-0 engineer">
                <option selected disabled>----</option>
                <option value="1">教師(国語)</option>
                <option value="2">教師(数学)</option>
                <option value="3">教師(英語)</option>
                <option value="4">生徒</option>
              </select>
            </div>
            
            <!-- 選択科目 -->
            <div class="selected_engineer">
              <label class="small font-weight-bold d-block mb-1">選択科目</label>
              <div class="d-flex flex-wrap gap-2">
                @foreach($subjects as $subject)
                <div class="form-check mr-2 mb-1">
                  <input type="checkbox" class="form-check-input" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest" id="subject_{{ $subject->id }}"
                    @if(is_array(request('subjects')) && in_array($subject->id, request('subjects'))) checked @endif>
                  <label class="form-check-label small" for="subject_{{ $subject->id }}">{{ $subject->subject }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        
        <div class="search_buttons">
          <input type="submit" class="btn btn-info btn-block text-white font-weight-bold shadow-sm mb-3" name="search_btn" value="検索" form="userSearchRequest">
          <div class="text-center">
            <input type="reset" class="btn btn-link btn-sm text-info text-decoration-none" value="リセット" form="userSearchRequest">
          </div>
        </div>
        
      </div>
      <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
    </div>
  </div>
</div>
</x-sidebar>
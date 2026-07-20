<x-sidebar>
<div class="w-100 min-vh-100 all_content p-5">
  <p class="top_title mb-4">{{ $user->over_name }} {{ $user->under_name }}さんのプロフィール</p>
  
  <div class="user_status p-4 shadow-sm">
    <div class="mb-2">
      <span class="text-muted mr-2">名前 :</span>
      <span class="font-weight-bold">{{ $user->over_name }}</span>
      <span class="font-weight-bold ml-1">{{ $user->under_name }}</span>
    </div>
    
    <div class="mb-2">
      <span class="text-muted mr-2">カナ :</span>
      <span class="text-secondary">{{ $user->over_name_kana }}</span>
      <span class="text-secondary ml-1">{{ $user->under_name_kana }}</span>
    </div>
    
    <div class="mb-2">
      <span class="text-muted mr-2">性別 :</span>
      @if($user->sex == 1)<span>男</span>
      @elseif($user->sex == 2)<span>女</span>
      @else<span>その他</span>
      @endif
    </div>
    
    <div class="mb-3">
      <span class="text-muted mr-2">生年月日 :</span>
      <span>{{ $user->birth_day }}</span>
    </div>
    
    <div class="mb-3">
      <span class="text-muted mr-2">選択科目 :</span>
      @foreach($user->subjects as $subject)
        <span class="badge badge-info mr-1 shadow-sm">{{ $subject->subject }}</span>
      @endforeach
    </div>
    
    @can('admin')
    <div class="border-top pt-3 mt-3">
      <p class="subject_edit_btn d-inline-flex align-items-center text-info mb-0 font-weight-bold">
        <span>選択科目の登録へ</span>
        <span class="arrow-icon ml-2"></span>
      </p>
      
      <div class="subject_inner mt-3">
        <form action="{{ route('user.edit') }}" method="post" class="d-flex align-items-center justify-content-between w-100">
          <div class="d-flex flex-wrap gap-3">
            @foreach($subject_lists as $subject_list)
            <div class="form-check form-check-inline mr-3">
              <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}" class="form-check-input" id="sub_{{ $subject_list->id }}"
              {{ $user->subjects->contains($subject_list->id) ? 'checked' : '' }}>
              <label class="form-check-label small font-weight-bold" for="sub_{{ $subject_list->id }}">{{ $subject_list->subject }}</label>
            </div>
            @endforeach
          </div>
          
          <div>
            <input type="submit" value="登録" class="btn btn-info btn-sm text-white font-weight-bold px-4 shadow-sm">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
          </div>
          {{ csrf_field() }}
        </form>
      </div>
    </div>
    @endcan
  </div>
</div>
</x-sidebar>
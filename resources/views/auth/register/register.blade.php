<x-guest-layout>
  <div class="w-100 min-vh-100 d-flex flex-column justify-content-center align-items-center py-5" style="background-color: #ECF1F6;">
    
    <!-- 新規登録フォームカード -->
    <div class="bg-white p-5 rounded shadow-sm border-0" style="width: 520px; max-width: 95%;">
      <form action="{{ route('registerPost') }}" method="POST">
        @csrf

        <!-- 姓・名エリア -->
        <div class="mb-4">
          @error('over_name')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          @error('under_name')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror

          <div class="d-flex" style="justify-content:space-between">
            <div style="width:48%">
              <label class="d-block m-0 text-secondary" style="font-size:13px">姓</label>
              <div class="border-bottom border-primary w-100">
                <input type="text" class="w-100 border-0 p-1 over_name" name="over_name" style="outline: none; box-shadow: none; background: transparent;">
              </div>
            </div>
            <div style="width:48%">
              <label class="d-block m-0 text-secondary" style="font-size:13px">名</label>
              <div class="border-bottom border-primary w-100">
                <input type="text" class="w-100 border-0 p-1 under_name" name="under_name" style="outline: none; box-shadow: none; background: transparent;">
              </div>
            </div>
          </div>
        </div>

        <!-- セイ・メイエリア -->
        <div class="mb-4">
          @error('over_name_kana')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          @error('under_name_kana')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror

          <div class="d-flex" style="justify-content:space-between">
            <div style="width:48%">
              <label class="d-block m-0 text-secondary" style="font-size:13px">セイ</label>
              <div class="border-bottom border-primary w-100">
                <input type="text" class="w-100 border-0 p-1 over_name_kana" name="over_name_kana" style="outline: none; box-shadow: none; background: transparent;">
              </div>
            </div>
            <div style="width:48%">
              <label class="d-block m-0 text-secondary" style="font-size:13px">メイ</label>
              <div class="border-bottom border-primary w-100">
                <input type="text" class="w-100 border-0 p-1 under_name_kana" name="under_name_kana" style="outline: none; box-shadow: none; background: transparent;">
              </div>
            </div>
          </div>
        </div>

        <!-- メールアドレス -->
        <div class="mb-4">
          @error('mail_address')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          <label class="m-0 d-block text-secondary" style="font-size:13px">メールアドレス</label>
          <div class="border-bottom border-primary w-100">
            <input type="email" class="w-100 border-0 p-1 mail_address" name="mail_address" style="outline: none; box-shadow: none; background: transparent;">
          </div>
        </div>

        <!-- 性別 -->
        <div class="mb-4">
          @error('sex')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          <div class="d-flex align-items-center flex-wrap" style="gap: 15px;">
            <div class="d-flex align-items-center">
              <input type="radio" name="sex" class="sex mr-1" value="1" id="sex_male">
              <label for="sex_male" class="m-0" style="font-size:13px">男性</label>
            </div>
            <div class="d-flex align-items-center">
              <input type="radio" name="sex" class="sex mr-1" value="2" id="sex_female">
              <label for="sex_female" class="m-0" style="font-size:13px">女性</label>
            </div>
            <div class="d-flex align-items-center">
              <input type="radio" name="sex" class="sex mr-1" value="3" id="sex_other">
              <label for="sex_other" class="m-0" style="font-size:13px">その他</label>
            </div>
          </div>
        </div>

        <!-- 生年月日 -->
        <div class="mb-4">
          @error('old_year')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          @error('old_month')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          @error('old_day')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          
          <label class="d-block mb-1 text-secondary" style="font-size:13px">生年月日</label>
          <div class="d-flex align-items-center flex-wrap" style="gap: 5px;">
            <select class="old_year form-control d-inline-block p-1" name="old_year" style="width: auto; height: auto; min-width: 80px;">
              <option value="none">-----</option>
              @for ($i = 1985; $i <= 2010; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
              @endfor
            </select>
            <span style="font-size:13px" class="mx-1">年</span>

            <select class="old_month form-control d-inline-block p-1" name="old_month" style="width: auto; height: auto; min-width: 60px;">
              <option value="none">-----</option>
              @for ($i = 1; $i <= 12; $i++)
                <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
              @endfor
            </select>
            <span style="font-size:13px" class="mx-1">月</span>

            <select class="old_day form-control d-inline-block p-1" name="old_day" style="width: auto; height: auto; min-width: 60px;">
              <option value="none">-----</option>
              @for ($i = 1; $i <= 31; $i++)
                <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
              @endfor
            </select>
            <span style="font-size:13px" class="mx-1">日</span>
          </div>
        </div>

        <!-- 役職 -->
        <div class="mb-4">
          @error('role')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          <label class="d-block mb-1 text-secondary" style="font-size:13px">役職</label>
          <div class="d-flex align-items-center flex-wrap" style="gap: 15px;">
            <div class="d-flex align-items-center">
              <input type="radio" name="role" class="admin_role role mr-1" value="1" id="role_ja">
              <label for="role_ja" class="m-0" style="font-size:13px">教師(国語)</label>
            </div>
            <div class="d-flex align-items-center">
              <input type="radio" name="role" class="admin_role role mr-1" value="2" id="role_math">
              <label for="role_math" class="m-0" style="font-size:13px">教師(数学)</label>
            </div>
            <div class="d-flex align-items-center">
              <input type="radio" name="role" class="admin_role role mr-1" value="3" id="role_en">
              <label for="role_en" class="m-0" style="font-size:13px">教師(英語)</label>
            </div>
            <div class="d-flex align-items-center">
              <input type="radio" name="role" class="other_role role mr-1" value="4" id="role_student">
              <label for="role_student" class="m-0 other_role" style="font-size:13px">生徒</label>
            </div>
          </div>
        </div>

        <!-- 選択科目 -->
        <div class="select_teacher d-none mb-4 bg-light p-3 rounded">
          <label class="d-block mb-2 font-weight-bold" style="font-size:13px">選択科目</label>
          @foreach($subjects as $subject)
          <div class="form-check mb-1">
            <input type="checkbox" name="subject[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}" class="form-check-input">
            <label for="subject_{{ $subject->id }}" class="form-check-label" style="font-size:13px">{{ $subject->subject }}</label>
          </div>
          @endforeach
        </div>

        <!-- パスワード -->
        <div class="mb-4">
          @error('password')
            <span class="text-danger d-block small mb-1">{{ $message }}</span>
          @enderror
          <label class="d-block m-0 text-secondary" style="font-size:13px">パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0 p-1 password" name="password" style="outline: none; box-shadow: none; background: transparent;">
          </div>
        </div>

        <!-- 確認用パスワード -->
        <div class="mb-4">
          <label class="d-block m-0 text-secondary" style="font-size:13px">確認用パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0 p-1 password_confirmation" name="password_confirmation" style="outline: none; box-shadow: none; background: transparent;">
          </div>
        </div>

        <!-- 新規登録ボタン -->
        <div class="text-right mt-4 mb-4">
          <input type="submit" class="btn btn-primary px-4 register_btn" disabled value="新規登録" onclick="return confirm('登録してよろしいですか？')" style="font-size: 14px; border-radius: 4px;">
        </div>

        <!-- ログインリンク -->
        <div class="text-center mt-3">
          <a href="{{ route('loginView') }}" class="text-primary small" style="text-decoration: none;">ログインはこちら</a>
        </div>
      </form>
    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}"></script>
</x-guest-layout>
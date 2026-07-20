<x-guest-layout>
  <div class="w-100 vh-100 d-flex flex-column justify-content-center align-items-center" style="background-color: #ECF1F6;">
    <!-- Atlas ロゴ画像エリア -->
    <div class="mb-4 text-center">
      <img src="{{ asset('image/atlas-black.png') }}" alt="Atlas" style="width: 150px; height: auto; display: inline-block;">
    </div>

    <!-- ログインフォームカード-->
    <div class="bg-white p-5 rounded shadow-sm border-0" style="width: 400px; max-width: 90%;">
      <form action="{{ route('loginPost') }}" method="POST">
        @csrf
        
        <!-- メールアドレス入力欄 -->
        <div class="mb-4">
          <label class="d-block m-0 text-secondary" style="font-size: 13px;">メールアドレス</label>
          <div class="border-bottom border-primary w-100">
            <input type="text" class="w-100 border-0 p-1" name="mail_address" style="outline: none; box-shadow: none; background: transparent;">
          </div>
        </div>

        <!-- パスワード入力欄 -->
        <div class="mb-4 pt-2">
          <label class="d-block m-0 text-secondary" style="font-size: 13px;">パスワード</label>
          <div class="border-bottom border-primary w-100">
            <input type="password" class="w-100 border-0 p-1" name="password" style="outline: none; box-shadow: none; background: transparent;">
          </div>
        </div>

        <!-- ログインボタン-->
        <div class="text-right mt-4 mb-4">
          <input type="submit" class="btn btn-primary px-4" value="ログイン" style="font-size: 14px; border-radius: 4px;">
        </div>

        <!-- 新規登録リンク-->
        <div class="text-center mt-3">
          <a href="{{ route('registerView') }}" class="text-primary small" style="text-decoration: none;">新規登録はこちら</a>
        </div>
      </form>
    </div>

  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}"></script>
</x-guest-layout>
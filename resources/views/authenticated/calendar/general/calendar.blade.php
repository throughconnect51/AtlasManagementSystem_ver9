<x-sidebar>
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">
      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <div class="p-3">
      <p class="mb-3">予約日：<span class="modal-date-text font-weight-bold"></span></p>
      <p class="mb-3">予約時間：<span class="modal-place-text font-weight-bold"></span>・<span class="modal-part-text font-weight-bold"></span></p>
      <p class="text-secondary mt-3 mb-0">上記の予約をキャンセルしてもよろしいですか？</p>
    </div>
    <div class="d-flex justify-content-between mt-4">
      <button type="button" class="btn btn-secondary js-modal-close">閉じる</button>
      <input type="submit" class="btn btn-danger" value="キャンセル" form="deleteParts">
    </div>
  </div>
</div>

<form action="{{ route('deleteParts') }}" method="post" id="deleteParts">
  @csrf
  <input type="hidden" name="delete_date" id="delete_date" value="">
  <input type="hidden" name="delete_part" id="delete_part" value="">
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function () {
    // モーダルを開く
    $('.js-modal-open').on('click', function () {
      $('.js-modal').fadeIn().css('display', 'flex'); // モーダルを表示
      
      // 押されたボタンから data 属性を取得
      var date = $(this).data('date');
      var part = $(this).data('part');
      var place = $(this).data('place');
      var partName = $(this).data('part-name');
      
      // モーダル内のテキストの書き換え
      $('.modal-date-text').text(date);
      $('.modal-place-text').text(place);
      $('.modal-part-text').text(partName);
      
      // 削除用フォームの input に値をセット
      $('#delete_date').val(date);
      $('#delete_part').val(part);
      return false;
    });

    // モーダルを閉じる
    $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;
    });
  });
</script>
</x-sidebar>
<x-sidebar>
<div class="w-100 min-vh-100 all_content d-flex justify-content-center align-items-center p-5" style="background: #ECF1F6;">
  <div class="w-100 p-5 shadow-sm bg-white" style="max-width: 1000px; border-radius: 12px;">
    <p class="text-center mb-4 font-weight-bold" style="font-size: 18px; color: #494949;">
      {{ $calendar->getTitle() }}
    </p>
    <div class="w-100">
      {!! $calendar->render() !!}
    </div>
    <div class="adjust-table-btn m-auto text-right mt-4">
      <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
    </div>
  </div>
</div>
</x-sidebar>
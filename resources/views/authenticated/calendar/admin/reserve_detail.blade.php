<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">

    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>
    
    <div class="h-75 border" style="overflow-y: auto;">
      <table class="w-100">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        
        @foreach($reservePersons as $reserveSetting)
          @foreach($reserveSetting->users as $user)
            <tr class="text-center">
              {{-- 1. ユーザーのID --}}
              <td class="w-25">{{ $user->id }}</td>
              
              {{-- 2. ユーザーの名前 --}}
              <td class="w-25">{{ $user->over_name }} {{ $user->under_name }}</td>
              
              {{-- 3. 予約場所（改修要件：リモートのみ） --}}
              <td class="w-25">リモート</td>
            </tr>
          @endforeach
        @endforeach
        
        @if($reservePersons->isEmpty() || $reservePersons->first()->users->isEmpty())
          <tr class="text-center">
            <td colspan="3" class="pt-3">予約しているユーザーはいません。</td>
          </tr>
        @endif
      </table>
    </div>
  </div>
</div>
</x-sidebar>
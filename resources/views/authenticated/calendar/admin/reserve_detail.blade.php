<x-sidebar>
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">

    <p class="reserve-detail-title"><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>
    
    <div class="reserve-detail-container" style="overflow-y: auto; max-height: 80%;">
      <table class="reserve-detail-table">
        <thead>
          <tr class="text-center">
            <th class="w-25">ID</th>
            <th class="w-25">名前</th>
            <th class="w-25">場所</th>
          </tr>
        </thead>
        
        <tbody>
          @foreach($reservePersons as $reserveSetting)
            @foreach($reserveSetting->users as $user)
              <tr class="text-center">
                {{-- 1. ユーザーのID --}}
                <td class="w-25">{{ $user->id }}</td>
                
                {{-- 2. ユーザーの名前 --}}
                <td class="w-25">{{ $user->over_name }} {{ $user->under_name }}</td>
                
                {{-- 3. 予約場所 --}}
                <td class="w-25">リモート</td>
              </tr>
            @endforeach
          @endforeach
          
          @if($reservePersons->isEmpty() || $reservePersons->first()->users->isEmpty())
            <tr class="text-center">
              <td colspan="3" class="pt-3 text-muted">予約しているユーザーはいません。</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
</x-sidebar>
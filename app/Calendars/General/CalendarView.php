<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        // 過去日判定（1日〜今日まで）
        $isPast = ($startDay <= $day->everyDay() && $toDay >= $day->everyDay());

        if($isPast){
          $html[] = '<td class="calendar-td bg-light text-muted" style="background-color: #dfdfdf !important;">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        
        $html[] = $day->render();

        // ログインユーザーが予約しているか判定
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          
          $place = "リモート";
          $partName = $reservePart . "部";
          $buttonText = "リモ" . $reservePart . "部";

          if($isPast){
            $html[] = '<p class="m-auto p-0 w-75 text-dark" style="font-size:12px; font-weight:bold;">'.$reservePart.'部 参加</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $setting_part = $day->authReserveDate($day->everyDay())->first()->setting_part;
            $html[] = '<button type="button" class="btn btn-danger p-0 w-75 js-modal-open"
            data-date="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'"
            data-part="'. $setting_part .'" 
            data-place="'. $place .'" 
            data-part-name="'. $partName .'">'. $buttonText .'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        }else{
          if($isPast){
            $html[] = '<p class="m-auto p-0 w-75 text-muted" style="font-size:12px;">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
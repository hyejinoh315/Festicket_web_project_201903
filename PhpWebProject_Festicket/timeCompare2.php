<?php

$timenow = date("Y-m-d");

$timetarget = $article['date']; //페스티벌 시작 날짜



$str_now = strtotime($timenow);

$str_target = strtotime($timetarget);





if($str_now >= $str_target) {
//echo "비교할 시간이 현재시간보다 작습니다."; -> 티켓을 판매할 수 없다
    echo "hidden";
}
//elseif($str_now == $str_target) {
//echo "비교할 시간이 현재시간과 같습니다.";
//}

 else {

}
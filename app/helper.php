<?php
function getDiffTimes($date){
    $to_time = strtotime("now");
    $from_time = strtotime($date);
    $prefix = "분";
    $minute = round(abs($to_time - $from_time) / 60);
    if($minute < 1) {
        $prefix = "초";
        $minute = round(abs($to_time - $from_time) % 60);
    }
    if($minute >= 60) {
        $prefix = "시간";
        $minute = round($minute / 60);
    }
    if($minute >= 24) {
        $prefix = "일";
        $minute = round($minute / 24);
    }
    if($minute ==0 )
        return "방금";
    else
        return $minute.$prefix;
}

?>

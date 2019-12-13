<?php

function calc_days($sd, $ed){

    $st = strtotime($sd);
    $et = strtotime($ed);
    $time_diff = $et - $st;
    $day_diff = round($time_diff/(60 * 60 * 24));
    return $day_diff;
}

function calc_price($sd, $ed, $ppd){
    return calc_days($sd, $ed) * $ppd;   
}

?>
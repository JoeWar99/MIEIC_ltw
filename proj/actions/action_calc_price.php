<?php
include_once("../includes/calc_price_days.php");

if(isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['ppd'])){

    $sd = $_GET['start_date'];
    $ed = $_GET['end_date'];
    $ppd = intval($_GET['ppd']);

    $daydiff = calc_days($sd, $ed);
    echo "" . $daydiff . " days * " . $ppd . "€/day = " . calc_price($sd, $ed, $ppd) . "€";
}

?>

<?php

if(isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['ppd'])){

    $sd = strtotime($_POST['start_date']);
    $ed = strtotime($_POST['end_date']);
    $ppd = intval($_POST['ppd']);

    $datediff = $ed - $sd;
    $daydiff = round($datediff / (60 * 60 * 24));
    echo "" . $daydiff . " days * " . $ppd . "€/day = " . $daydiff * $ppd . "€";
}

?>

<?php
if(isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['ppd'])){

    $sd = new DateTime($_POST['start_date']);
    $ed = new DateTime($_POST['end_date']);
    $ppd = intval($_POST['ppd']);

    $difference = $sd->diff($ed);
    echo $ppd * $difference['days'];
}
?>

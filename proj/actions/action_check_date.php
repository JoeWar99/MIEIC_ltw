<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if(isset($_GET['date']) && isset($_GET['hid'])){
    if(is_date_available($_GET['date'], $_GET['id'])) echo "true";
    else echo "false";   
}

else var_dump($_GET);
?>
<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

// if the values that should be sent by get are set then we proceed
if(isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['id'])){
    
    // checking if the house is occupied or not
    if(!is_house_occupied( intval($_GET['id']), $_GET['start_date'], $_GET['end_date'])) echo "YAY";
    else echo "NAY";
}

else var_dump($_GET);
?>
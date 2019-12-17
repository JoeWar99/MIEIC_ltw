<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

// if the values are set then we procced
if(isset($_GET['date']) && isset($_GET['id'])){
    
    // checking if the house is occupied or not
    if(!is_date_occupied($_GET['date'], $_GET['id'])) echo "YAY";
    else echo "NAY";
}

else var_dump($_GET);
?>
<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if(isset($_GET['date']) && isset($_GET['id'])){
    
    if(!is_date_occupied($_GET['date'], $_GET['id'])) echo "YAY";
    else echo "NAY";
}

else var_dump($_GET);
?>
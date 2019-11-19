  
<?php

include_once('database/db_functions.php');

if(($userID = Login($_POST['username_or_email'], $_POST['password'])) != -1){

	header("Location:home_page.php");
} 
else {
    header("Location:login_page.php");
}
?>
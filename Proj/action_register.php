<?php

include_once('database/db_functions.php');

var_dump($_POST);

if(createUser($_POST['name'], $_POST['dateofbirth'], $_POST['username'], $_POST['email'], $_POST['password']) != -1){
   header("Location:login_page.php");

}
else {
    header("Location:register_page.php");
}
?>
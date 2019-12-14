<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');

if (!isset($_GET['hid'])) var_dump($_GET);
else header('Location: ../pages/homepage.php');

?>
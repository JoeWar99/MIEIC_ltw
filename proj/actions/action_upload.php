<?php
include_once('../includes/session.php');
// Get image ID


$id = 1;

$temp_array = array();
$i = 0;
$key = "name";
$key_array = array();


foreach ($_FILES as $val) {
    if (!in_array($val[$key], $key_array)) {
      $key_array[$i] = $val[$key];
      $temp_array[$i] = $val;
    }
  $i++;
}

$i = 0;

// Move the uploaded file to its final destination
foreach ($temp_array as $val) {
  $originalFileName_string = "../assets/imagesHouses/houseImage_" . $id . "_" . $i . ".jpg";

  if(file_exists($originalFileName_string)) {
    echo "entrei aqui";
    chmod($originalFileName_string,0755); //Change the file permissions if allowed
    unlink($originalFileName_string); //remove the file
  }

  if ($val['name'] != '')
    move_uploaded_file($val['tmp_name'], $originalFileName_string);

  $i++;
}



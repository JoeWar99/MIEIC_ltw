<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
// Get image ID
file_put_contents('somefilename.txt', print_r($_POST, true), FILE_APPEND);

$house_name = $_POST["HouseName"];
$price_per_day = $_POST["PricePerDay"];
$adress = $_POST["Adress"];
$description = $_POST["description"];
$postal_code = $_POST["PostalCode"];
$city = $_POST["City"];
$country = $_POST["Country"];
$capacity = $_POST["Capacity"];
$username = $_SESSION['username'];
$File0 = $_POST['File0'];
$File1 = $_POST['File1'];
$File2 =  $_POST['File2'];
$File3 =  $_POST['File3'];
$File4 =  $_POST['File4'];
$File5 =  $_POST['File5'];
$commodities = $_POST['commodities'];

$Files_bool = array();


array_push($Files_bool, $File0, $File1, $File2, $File3, $File4, $File5);
file_put_contents('somefilename.txt', print_r($Files_bool, true), FILE_APPEND);

if (!insert_new_property($house_name, $price_per_day, $adress, $description, $postal_code, $city, $country, $capacity,$commodities, $username)) {
  echo json_encode(-1);
  file_put_contents('somefilename.txt', print_r('shit', true), FILE_APPEND);
} else {

  // $temp_array = array();
  // $i = 0;
  // $key = "name";
  // $key_array = array();


  // foreach ($_FILES as $val) {
  //   if($Files[$i] == true){
  //       file_put_contents('somefilename.txt', print_r($_FILES, true), FILE_APPEND);
  //     if (!in_array($val[$key], $key_array)) {
  //       $key_array[$i] = $val[$key];
  //       $temp_array[$i] = $val;
  //     }
  //   }
  //   $i++;
  // }
  
  $db = Database::instance()->db();
  $id = $db->lastInsertId();
  $i = 0;

  file_put_contents('somefilename.txt', print_r($id, true), FILE_APPEND);
  file_put_contents('somefilename.txt', print_r($_FILES, true), FILE_APPEND);

  // Move the uploaded file to its final destination
  foreach ($_FILES as $val) {
    file_put_contents('somefilename.txt', print_r($Files_bool[$i], true), FILE_APPEND);
    if ($Files_bool[$i] == 1) {
      $originalFileName_string = "../assets/imagesHouses/houseImage_" . $id . "_" . $i . ".jpg";

      if (file_exists($originalFileName_string)) {
        chmod($originalFileName_string, 0755); //Change the file permissions if allowed
        unlink($originalFileName_string); //remove the file
      }

      if ($val['name'] != '') {
        file_put_contents('somefilename.txt', print_r('adicionar o path', true), FILE_APPEND);
        move_uploaded_file($val['tmp_name'], $originalFileName_string);
        if (!add_photo_path_to_house($id, $originalFileName_string)) {
          echo json_encode(-1);
          exit;
        }
      }
    }
    else if($Files_bool[$i] == 0){
      $originalFileName_string = "../assets/imagesHouses/houseImage_" . $id . "_" . $i . ".jpg";
      if (file_exists($originalFileName_string)) {
        chmod($originalFileName_string, 0755); //Change the file permissions if allowed
        unlink($originalFileName_string); //remove the file
      }
    }
    $i++;
  }

  file_put_contents('somefilename.txt', print_r('LOL2', true), FILE_APPEND);

  echo json_encode(0);
}

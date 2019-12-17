<?php
include_once('../includes/session.php');
include_once('../database/db_functions.php');
// Get image ID

$house_name = trim(strip_tags($_POST["HouseName"]));
$price_per_day = trim(strip_tags($_POST["PricePerDay"]));
$adress = trim(strip_tags($_POST["Adress"]));
$description = trim(strip_tags($_POST["description"]));
$postal_code = trim(strip_tags($_POST["PostalCode"]));
$city = trim(strip_tags($_POST["City"]));
$country = trim(strip_tags($_POST["Country"]));
$capacity = trim(strip_tags($_POST["Capacity"]));
$username = $_SESSION['username'];
$File0 = trim(strip_tags($_POST['File0']));
$File1 = trim(strip_tags($_POST['File1']));
$File2 =  trim(strip_tags($_POST['File2']));
$File3 =  trim(strip_tags($_POST['File3']));
$File4 =  trim(strip_tags($_POST['File4']));
$File5 =  trim(strip_tags($_POST['File5']));
$commodities = trim(strip_tags($_POST['commodities']));

$Files_bool = array();


array_push($Files_bool, $File0, $File1, $File2, $File3, $File4, $File5);

if (!insert_new_property($house_name, $price_per_day, $adress, $description, $postal_code, $city, $country, $capacity,$commodities, $username)) {
  echo json_encode(-1);

} else {


  
  $db = Database::instance()->db();
  $id = $db->lastInsertId();
  $i = 0;

  
  // Move the uploaded file to its final destination
  foreach ($_FILES as $val) {
   
    if ($Files_bool[$i] == 1) {
      $originalFileName_string = "../assets/imagesHouses/houseImage_" . $id . "_" . $i . ".jpg";

      if (file_exists($originalFileName_string)) {
        chmod($originalFileName_string, 0755); //Change the file permissions if allowed
        unlink($originalFileName_string); //remove the file
      }

      if ($val['name'] != '') {
       
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



  echo json_encode(0);
}

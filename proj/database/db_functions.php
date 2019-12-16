<?php
include_once('../includes/database.php');

/**
 * Inserts a user in the database
 */
function create_user($name, $date, $email, $username, $password)
{
    $db = Database::instance()->db();
    $options = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO User VALUES(?, ?, ?, ?, ?, ?, NULL, NULL)');
    $stmt->execute(array(null, $name, $date, $email, $username, password_hash($password, PASSWORD_DEFAULT, $options)));
}

function is_house_occupied($hid, $start_date, $end_date){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM Occupied WHERE MAX(StartDate, ?) <= MIN(EndDate, ?) AND HouseId = ?');
    $stmt->execute(array($start_date, $end_date, $hid));
    $result = $stmt->fetch();
    return $result;
}

function is_date_occupied($date, $hid){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Occupied WHERE HouseId = ? AND StartDate <= ? AND EndDate >= ?;");
    $stmt->execute(array($hid, $date, $date));
    $result = $stmt->fetch();
    return $result;
}

function create_rent($start_date, $end_date, $price, $hid, $tid){
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO Rent (StartDate, EndDate, Price, HouseId, TouristId) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute(array($start_date, $end_date, $price, $hid, $tid));
}

/**
 * Verifies if a certain username, password combination
 * exists in the database. Use the sha1 hashing function.
 */
function check_usr_pass($username_or_email, $password)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username_or_email));
    $user = $stmt->fetch();

    $stmt = $db->prepare('SELECT * FROM User WHERE email = ?');
    $stmt->execute(array($username_or_email));
    $email = $stmt->fetch();

    if($user !== false){
        return password_verify($password, $user['Password']);
    }
    else if($email !== false){
        return password_verify($password, $email['Password']);
    }
    else
        return false;
}

function username_exists($username)
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM User WHERE username = ?;");
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    return (isset($result['total']) and $result['total'] > 0); // returns true if email exists and false otherwise..

}

function email_exists($email)
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM User WHERE email = ?;");
    $stmt->execute(array($email));
    $result = $stmt->fetch();
    return (isset($result['total']) and $result['total'] > 0); // returns true if email exists and false otherwise..

}

function get_top_rated_houses()
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM House ORDER BY Rating DESC LIMIT 0, 6;");
    $stmt->execute(array());
    $result = $stmt->fetchall();
    return $result; // returns true if email exists and false otherwise..
}

function count_comments($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total
    FROM Comment C JOIN Review Re ON C.ReviewId = Re.Id JOIN Rent R ON Re.RentId = R.Id JOIN House H ON R.HouseId = H.Id 
    Where HouseId = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result['total']; // returns true if email exists and false otherwise..
}

function get_house_top_pic($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Path as path FROM House H join Photo P on H.Id = P.HouseId WHERE H.Id = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result['path']; // returns true if email exists and false otherwise..
}

function get_house_by_id($house_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM House WHERE Id = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result;

}

function get_commodities_by_house_id($house_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Commodity WHERE HouseId = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetchall();
    return $result;
}

function get_city_by_id($city_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM City WHERE Id = ?;");
    $stmt->execute(array(intval($city_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_country_by_id($country_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Country WHERE Id = ?;");
    $stmt->execute(array(intval($country_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_house_owner($house_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Name, Email FROM User WHERE Id = (SELECT OwnerId From House WHERE House.Id = ?);");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_recent_comments($house_id){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT U.Username, C.Text, C.Date
    FROM Comment C JOIN Review Re ON C.ReviewId = Re.Id JOIN Rent R ON Re.RentId = R.Id
    JOIN User U ON R.TouristId = U.Id JOIN House H ON R.HouseId = H.Id Where HouseId = ? ORDER BY C.Date DESC LIMIT 3;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetchall();
    return $result;
}


function get_all_properties_for_a_user($usr){
    $db = Database::instance()->db();
    $user_id = get_id_from_usr($usr);
    if($user_id != -1){
        try{
            $stmt = $db->prepare("SELECT DISTINCT * 
            FROM House WHERE House.OwnerId = ? ");
            $stmt->execute(array($user_id));
            $result = $stmt->fetchall();
            if(count($result) == 0)
                return -1;
            else
                return $result;
        }
        catch (PDOException $e){
            return -1;
        }
    }
    else
        return -1;
}

function get_all_reservations_for_a_user($usr){
    $db = Database::instance()->db();
    $user_id = get_id_from_usr($usr);
    if($user_id != -1){
        try{
            $stmt = $db->prepare(" SELECT DISTINCT H.Id, H.Name, H.Rating, H.PricePerDay, H.Description, H.Address, H.PostalCode, H.OwnerId, H.CityId, H.Capacity
            FROM User U JOIN Rent R ON U.Id = R.TouristId JOIN House H ON R.HouseId = H.Id 
            WHERE U.ID = ? ORDER BY R.StartDate ASC");
            $stmt->execute(array($user_id));
            $result = $stmt->fetchall();
            if(count($result) == 0)
                return -1;
            else
                return $result;
        }
        catch (PDOException $e){
            return -1;
        }
    }
    else
        return -1;
}

function get_name_from_id($usrid){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Username FROM User WHERE Id = ?");
    $stmt->execute(array($usrid));
    $result = $stmt->fetch();
    return $result;
}

function get_msgs_bw_2_usrs($usrid1, $usrid2){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Message WHERE (SenderId = ? AND ReceiverId = ?) OR (SenderId = ? AND ReceiverId = ?) ORDER BY SentDate ASC");
    $stmt->execute(array($usrid1, $usrid2, $usrid2, $usrid1));
    $result = $stmt->fetchAll();
    return $result;
}

function get_usr_msgs($usrid){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Message WHERE SenderId = ? OR ReceiverId = ?");
    $stmt->execute(array($usrid, $usrid));
    $result = $stmt->fetchAll();
    return $result;
}

function get_usr_sent_contacts_ids($usrid){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT ReceiverId FROM Message WHERE SenderId = ?");
    $stmt->execute(array($usrid));
    $result = $stmt->fetchAll();
    
    $ids = array();
    foreach($result as $res) array_push($ids, intval($res['ReceiverId']));
    return $ids;
}

function get_usr_received_contacts_ids($usrid){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT SenderId FROM Message WHERE ReceiverId = ?");
    $stmt->execute(array($usrid));
    $result = $stmt->fetchAll();

    $ids = array();
    foreach($result as $res) array_push($ids, intval($res['SenderId']));
    return $ids;
}

function get_usr_contacts($usrid){
    return array_unique(array_merge(get_usr_sent_contacts_ids($usrid), get_usr_received_contacts_ids(($usrid))));
}

function find_me_a_cozy_place($city_id, $start_date, $end_date, $guest_no){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Id, Name, Rating, PricePerDay, CityId FROM House
    WHERE (House.CityId = ? AND House.Capacity >= ? AND House.Id NOT IN (SELECT HouseId FROM Occupied WHERE (SELECT MAX(StartDate, ?)) <= (SELECT MIN(EndDate, ?))));");
    $stmt->execute(array(intval($city_id), $guest_no, $start_date, $end_date));
    $result = $stmt->fetchall();
    return $result;
}

function get_location_from_names($city_name, $country_name){
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT City.Id, City.CountryId FROM City, Country WHERE City.Name = ? AND City.CountryId = Country.Id AND Country.Name = ?;");
    $stmt->execute(array($city_name, $country_name));
    $result = $stmt->fetch();
    return $result;
}


/* Auxiliar develpment functions to delete before work is finalized */

/**
 * Gets all the users from the database
 */
function get_all_users()
{
    $dbh = Database::instance()->db();
    $stmt = $dbh->prepare('SELECT * FROM User');
    $stmt->execute();
    return $stmt->fetchall();
}

/**
 * get_id_from_usr
 * @param string $username  username of the user we want to get the id of
 * @return int returns -1 if it wasnt sucessfull or returns the id of the specified user if sucessfull
 */
function get_id_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT Id FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Id'];
    } catch (PDOException $e) {
        return -1;
    }
}

function get_name_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT Name FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Name'];
    } catch (PDOException $e) {
        return -1;
    }
}

function get_email_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT Email FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Email'];
    } catch (PDOException $e) {
        return -1;
    }
}

function get_date_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT DateOfBirth FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['DateOfBirth'];
    } catch (PDOException $e) {
        return -1;
    }
}

function get_description_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT Description FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Description'];
    } catch (PDOException $e) {
        return NULL;
    }
}

function get_photo_from_usr($username)
{
    $dbh = Database::instance()->db();
    try {
        $stmt = $dbh->prepare('SELECT Photo FROM User WHERE Username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Photo'];
    } catch (PDOException $e) {
        return NULL;
    }
}

function new_username($old_username, $new_username)
{
    try {
        $db = Database::instance()->db();
        $id = get_id_from_usr($old_username);
        $query = "UPDATE User SET Username = '" . $new_username . "' WHERE Id = " . $id;
        $res = $db->query($query);
        return 0;
    } catch(PDOException $e) {
        return -1;
    }
}

function new_password($username, $new_password)
{
    try {
        $db = Database::instance()->db();
        $id = get_id_from_usr($username);
        $options = ['cost' => 12];
        $password = password_hash($new_password, PASSWORD_DEFAULT, $options);
        $query = "UPDATE User SET Password = '" . $password . "' WHERE Id = " . $id;
        $res = $db->query($query);
        return 0;
    } catch(PDOException $e) {
        return -1;
    }
}

function new_description($username, $description)
{
    try {
        $db = Database::instance()->db();
        $id = get_id_from_usr($username);
        $query = "UPDATE User SET Description = '" . $description . "' WHERE Id = " . $id;
        $res = $db->query($query);
        return 0;
    } catch(PDOException $e) {
        return -1;
    }
}

function new_photo($username, $photo)
{
    try {
        $db = Database::instance()->db();
        $id = get_id_from_usr($username);
        $query = "UPDATE User SET Photo = '" . $photo . "' WHERE Id = " . $id;
        $res = $db->query($query);
        return 0;
    } catch(PDOException $e) {
        return -1;
    }
}


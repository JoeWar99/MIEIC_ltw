<?php
include_once('../includes/database.php');

/**
 * Inserts a user in the database
 */
function create_user($name, $date, $email, $username, $password)
{
    $db = Database::instance()->db();
    $options = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO User VALUES(?, ?, ?, ?, ?, ?)');
    $stmt->execute(array(null, $name, $date, $email, $username, password_hash($password, PASSWORD_DEFAULT, $options)));
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

    if ($user !== false) {
        return password_verify($password, $user['Password']);
    } else if ($email !== false) {
        return password_verify($password, $email['Password']);
    } else
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

function get_house_by_id($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM House WHERE Id = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_commodities_by_house_id($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Commodity WHERE HouseId = ?;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetchall();
    return $result;
}

function get_city_by_id($city_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM City WHERE Id = ?;");
    $stmt->execute(array(intval($city_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_country_by_id($country_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM Country WHERE Id = ?;");
    $stmt->execute(array(intval($country_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_house_owner($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Name, Email FROM User WHERE Id = (SELECT OwnerId From House WHERE House.Id = ?);");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetch();
    return $result;
}

function get_recent_comments($house_id)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT U.Username, C.Text, C.Date
    FROM Comment C JOIN Review Re ON C.ReviewId = Re.Id JOIN Rent R ON Re.RentId = R.Id
    JOIN User U ON R.TouristId = U.Id JOIN House H ON R.HouseId = H.Id Where HouseId = ? ORDER BY C.Date DESC LIMIT 3;");
    $stmt->execute(array(intval($house_id)));
    $result = $stmt->fetchall();
    return $result;
}


function get_all_properties_for_a_user($usr)
{
    $db = Database::instance()->db();
    $user_id = get_id_from_usr($usr);
    if ($user_id != -1) {
        try {
            $stmt = $db->prepare("SELECT DISTINCT * 
            FROM House WHERE House.OwnerId = ? ");
            $stmt->execute(array($user_id));
            $result = $stmt->fetchall();
            if (count($result) == 0)
                return -1;
            else
                return $result;
        } catch (PDOException $e) {
            return -1;
        }
    } else
        return -1;
}
function get_all_reservations_for_a_user($usr)
{
    $db = Database::instance()->db();
    $user_id = get_id_from_usr($usr);
    if ($user_id != -1) {
        try {
            $stmt = $db->prepare(" SELECT DISTINCT H.Id, H.Name, H.Rating, H.PricePerDay, H.Description, H.Address, H.PostalCode, H.OwnerId, H.CityId, H.Capacity, R.Id as RentId, R.StartDate, R.EndDate
            FROM User U JOIN Rent R ON U.Id = R.TouristId JOIN House H ON R.HouseId = H.Id 
            WHERE U.ID = ? ORDER BY R.StartDate ASC");
            $stmt->execute(array($user_id));
            $result = $stmt->fetchall();
            if (count($result) == 0)
                return -1;
            else
                return $result;
        } catch (PDOException $e) {
            return -1;
        }
    } else
        return -1;
}


function delete_house($house_id)
{

    $db = Database::instance()->db();
    try {
        $stmt = $db->prepare("DELETE FROM House WHERE House.Id=?");
        $stmt->execute(array($house_id));
        return true;
    } catch (PDOException $e) {
        return false;
    }

}

function cancel_reservation($rent_id){
    $db = Database::instance()->db();
    try {
        $stmt = $db->prepare("SELECT * FROM Rent WHERE Rent.Id=?");
        $stmt->execute(array($rent_id));
        $ret = $stmt->fetch();

        $date = date('Y/m/d', time());

        if($date > $ret['StartDate'] && $date < $ret['EndDate']){
            return -1;
        }
        else{
            $stmt = $db->prepare("DELETE FROM Rent WHERE Rent.Id=?");
            $stmt->execute(array($rent_id));
            return true;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function insert_new_property($house_name, $price_per_day, $adress, $description, $postal_code, $city, $country, $capacity, $username){
    $db = Database::instance()->db();
    try{
        $onwer_id = get_id_from_usr($username);
        $stmt = $db->prepare("INSERT INTO House (id, Name, Rating, Description, PricePerDay, Address, PostalCode, OwnerId, CityId, Capacity) values (?,?,?,?,?,?,?,?,?,?);");
        $stmt->execute(array(null, $house_name, 0, $description, $price_per_day, $adress, $postal_code, $onwer_id, 1, $capacity));
        return true;
    } catch (PDOException $e) {
        return false;
    }
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
        $stmt = $dbh->prepare('SELECT Id FROM User WHERE username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if ($user !== false)
            return $user['Id'];
    } catch (PDOException $e) {
        return -1;
    }
}

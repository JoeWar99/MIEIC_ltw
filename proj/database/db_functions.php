<?php
include_once('../includes/database.php');

/**
 * Inserts a user in the database
 */
function createUser($name, $date, $email, $username, $password)
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
function checkUserEmailPassword($username_or_email, $password)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
    $stmt->execute(array($username_or_email));
    $user = $stmt->fetch();
    return $user !== false && password_verify($password, $user['Password']);
}

function usernameExists($username)
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM User WHERE username = ?;");
    $stmt->execute(array($username));
    $result = $stmt->fetch();
    return (isset($result['total']) and $result['total'] > 0); // returns true if email exists and false otherwise..

}

function emailExists($email)
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM User WHERE email = ?;");
    $stmt->execute(array($email));
    $result = $stmt->fetch();
    return (isset($result['total']) and $result['total'] > 0); // returns true if email exists and false otherwise..

}

function getHousesBestRatings()
{

    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT * FROM House ORDER BY Rating ASC LIMIT 0, 6;");
    $stmt->execute(array());
    $result = $stmt->fetchall();
    return $result; // returns true if email exists and false otherwise..
}

function numberOfCommentsPerHouse($idHouse)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT COUNT(*) as total
    FROM Comment C JOIN Review Re ON C.ReviewId = Re.Id JOIN Rent R ON Re.RentId = R.Id JOIN House H ON R.HouseId = H.Id 
    Where HouseId = ?;");
    $stmt->execute(array(intval($idHouse)));
    $result = $stmt->fetch();
    return $result['total']; // returns true if email exists and false otherwise..
}

function pathPrincipalImageHouse($idHouse)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare("SELECT Path as path FROM House H join Photo P on H.Id = P.HouseId WHERE H.Id = ?;");
    $stmt->execute(array(intval($idHouse)));
    $result = $stmt->fetch();
    return $result['path']; // returns true if email exists and false otherwise..
}



/* Auxiliar develpment functions to delete before work is finalized */

/**
 * Gets all the users from the database
 */
function getAllUsers()
{
    $dbh = Database::instance()->db();
    $stmt = $dbh->prepare('SELECT * FROM User');
    $stmt->execute();
    return $stmt->fetchall();
}



/**
 * getIdFromUsername
 * @param string $username  username of the user we want to get the id of
 * @return int returns -1 if it wasnt sucessfull or returns the id of the specified user if sucessfull
 */
function getIdFromUsername($username)
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

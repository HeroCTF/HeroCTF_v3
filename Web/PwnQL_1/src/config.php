<?php

define("FLAG", getenv("PWNQL_1_FLAG"));

$mysq_host = getenv('MYSQL_HOST');
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

try {
    $db = new PDO(
        "mysql:host=${mysq_host};dbname=${mysql_database};charset=utf8",
        $mysql_user,
        $mysql_password
    );
} catch (PDOException $e) {
    echo("Error : Failed to connect to the database, please wait !");
    die();
}

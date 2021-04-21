<?php

define("FLAG", getenv("PWNQL_1_FLAG"));

function debugMode() {
    return getenv('DEBUG') === 'true';
}

if (debugMode()) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$mysq_host = getenv('MYSQL_HOST');
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");

try {
    $pdo = new PDO(
        "mysql:host=${mysq_host};dbname=${mysql_database};charset=utf8",
        $mysql_user,
        $mysql_password
    );
    if (debugMode()) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
} catch (PDOException $e) {
    echo("Error : Failed to connect to the database, please wait !");
    if (debugMode()) {
        var_dump($e->getMessage());
    }
    die();
}

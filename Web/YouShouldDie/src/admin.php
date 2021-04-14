<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)) {
    header("Location: /index.php?error=You are not admin !");
}

echo "Flag : " . getenv("FLAG_MARK3TING");
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_DEPRECATED);
require('Controllers/ApplicationController.php');
session_start();

if(!isset($_REQUEST['page']))
    $_REQUEST['page'] = '/';

$controller = ApplicationController::getInstance()->getController($_REQUEST);
if ($controller != null) {
    include "Controllers/$controller.php";
    (new $controller())->handle($_REQUEST);
}

$view = ApplicationController::getInstance()->getView($_REQUEST);
if ($view != null) {
    include "Views/$view.php";
}

$_SESSION['message'] = null;

?>

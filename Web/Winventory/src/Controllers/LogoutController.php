<?php
require_once("Controller.php");
class LogoutController implements Controller
{
    /**
     * @param Request the request from clients
     * This method is used to verify if a user is already logged in. If not, try to disconnect the current user.
     */
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=home');
        else $this->disconnect();
    }

    public function disconnect(){
        session_destroy();
        header("Location:?page=/");
    }
}
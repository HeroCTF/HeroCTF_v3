<?php
require_once("Model/UserDAO.php");
require_once("Controller.php");
class LoginController implements Controller
{
    /**
     * @param Request the request from clients
     * This method is used to verify if a user is already logged in. If not, try to connect him with the provided credentials.
     */
    public function handle($request)
    {
        if (isset($_SESSION['email'])) header('Location:?page=home');
        else $this->connect();
    }

    public function connect(){
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["email"]) && isset($_POST['password'])){
            $_SESSION['msgE'] = "";
            $_SESSION['msg'] = "";
            if(!empty($_POST["email"]) && !empty($_POST['password'])){
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $userEmail = UserDAO::getInstance()->findUser($email);
                if($userEmail){
                    if($userEmail->isPasswordValid($password) === True){
                        $_SESSION['email'] = $email;
                        header('Location:?page=home');
                    }else{
                        $_SESSION['msgE'] = "Wrong credentials.";
                    }
                }else{
                    $_SESSION['msgE'] = "Wrong credentials.";
                }
            }else{
                $_SESSION['msgE'] = "A field can't be empty.";
            }
        }else{
            $_SESSION['msgE'] = 'A field is missing.';
        }
        header("Location:?page=/");
    }
}
?>
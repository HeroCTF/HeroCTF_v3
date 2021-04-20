<?php
require_once("Controller.php");
require_once("Model/User.php");
require_once("Model/UserDAO.php");
class ProfileController implements Controller
{
    /**
     * @param Request the request from clients
     * This method is used to verify if a user is already logged in. If not, try to update his profile with the provided informations.
     */
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=home');
        else $this->update();
    }

    public function update(){
        if(isset($_POST['pseudo'])){
            $idUser = UserDAO::getInstance()->findUser($_SESSION['email'])->id;
            if($idUser !== "61"){
                $_SESSION['msgE'] = "";
                $_SESSION['msg'] = "";
                if(isset($_POST['password']) && empty($_POST['password'])){
                    UserDAO::getInstance()->updatePseudo(htmlspecialchars($_POST['pseudo']));
                    $_SESSION['msg'] = "Your profile has been updated.";
                }else{
                    if(isset($_POST['repeat_password'])){
                        $uppercase = preg_match('@[A-Z]@', $_POST['password']);
                        $lowercase = preg_match('@[a-z]@', $_POST['password']);
                        $number = preg_match('@[0-9]@', $_POST['password']);

                        if ($uppercase == 1 && $lowercase == 1 && $number == 1 && strlen($_POST['password']) >= 8) {
                            if($_POST['repeat_password'] === $_POST['password']){
                                $user = new User();
                                $user->init(htmlspecialchars($_POST['pseudo']),$_SESSION['email'],htmlspecialchars($_POST['password']));
                                UserDAO::getInstance()->updatePassword($user);
                                $_SESSION['msg'] = "Your profile has been updated.";
                            }else{
                                $_SESSION['msgE'] = 'Password aren\'t identical, please try again.';
                            }
                        }else{
                            $_SESSION['msgE'] = "Password must be at least 8 characters and contains one uppercase, one lowercase, and one number.";
                        }
                    }else{
                        $_SESSION['msgE'] = "Missing field. Please try again.";
                    }
                }
            }else{
                $_SESSION['msgE'] = 'Admin can\'t modify is profile.';
                header("Location:?page=profile");
            }
        }else{
            $_SESSION['msgE'] = 'Pseudo field can\'t be empty';
        }
        header("Location:?page=profile");
    }
}
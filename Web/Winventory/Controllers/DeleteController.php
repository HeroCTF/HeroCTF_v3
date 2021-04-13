<?php
require_once("Controller.php");
require_once("Model/UserDAO.php");
require_once("Model/LivresDAO.php");
require_once("Model/MaisonsDAO.php");
class DeleteController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=home');
        else $this->delete();
    }

    public function delete(){
        if(isset($_POST['password']) && isset($_POST['repeat_password'])){
            if(!empty($_POST['password']) && !empty($_POST['repeat_password'])){
                if($_POST['repeat_password'] === $_POST['password']){
                    $currentUser = UserDAO::getInstance()->findUser($_SESSION['email']);
                    $password = htmlspecialchars($_POST['password']);
                    if($currentUser->isPasswordValid($password) === True){
                        $id = $currentUser->id;
                        if($currentUser->isAdmin === "1"){
                            $_SESSION['msgE'] = 'Admin can\'t delete is account';
                            header("Location:?page=delete");
                        }else{
                            $allBooks = LivresDAO::getInstance()->findLivres($id);
                            $allHouses = MaisonsDAO::getInstance()->findHouses($id);
                            foreach($allBooks as $books){
                                LivresDAO::getInstance()->delete($books->getId());
                            }
                            foreach($allHouses as $house){
                                MaisonsDAO::getInstance()->delete($house->getId());
                            }
                            UserDAO::getInstance()->delete($_SESSION['email']);
                            session_destroy();
                            header("Location:?page=/");
			            }
                    }else{
                        $_SESSION['msgE'] = 'Wrong password.';
                    }
                }else{
                    $_SESSION['msgE'] = 'Both fields aren\'t identical';
                }
            }else{
                $_SESSION['msgE'] = 'Both fields can\'t be empty.';
            }
        }else{
            $_SESSION['msgE'] = 'Missing fields.';
        }
        header("Location:?page=delete");
    }
}

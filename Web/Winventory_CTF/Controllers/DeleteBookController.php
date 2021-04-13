<?php
require_once("Model/LivresDAO.php");
require_once("Model/UserDAO.php");
require_once("Controller.php");
class DeleteBookController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        else $this->deleteBook();
    }

    public function deleteBook(){
        $_SESSION['msg'] = "";
        $_SESSION['msgE'] = "";
        $id = -1;
        foreach(array_keys($_POST) as $key){
            $id = $key;
        }
        if($id !== -1 && is_integer($id)){
            $idUser = UserDAO::getInstance()->findUser($_SESSION["email"])->id;
            $books = LivresDAO::getInstance()->findLivres($idUser);
            $ownedByUser = False;
            foreach($books as $b){
                if($b->getId() == $id){
                    $ownedByUser = True;
                    break;
                }
            }
            if($ownedByUser === True){
                LivresDAO::getInstance()->delete($id);
                $_SESSION['msg'] = 'The book has been deleted.';
            }else{
                $_SESSION['msgE'] = 'This book is not owned by you. You can\'t delete it.';
            }
        }else{
            $_SESSION['msgE'] = 'An error occured, please try again.';
        }
        header("Location:?page=manageBooks");
    }
}
<?php
require_once("Model/Livres.php");
require_once("Model/LivresDAO.php");
require_once("Controller.php");
require_once("Model/UserDAO.php");
require_once("Model/MaisonsDAO.php");
class AddNewBookController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        else $this->addLivre();
    }

    public function addLivre(){
        $_SESSION['msg'] = "";
        $_SESSION['msgE'] = "";
        $currentUser = UserDAO::getInstance()->findUser($_SESSION['email']);
        if($currentUser->isAdmin !== "1"){
            if(isset($_POST['titre']) && isset($_POST['auteur']) && isset($_POST['prix']) && isset($_POST['house']) && isset($_POST['maxPage'])){
                if(!empty($_POST['titre']) && !empty($_POST['auteur']) && !empty($_POST['prix']) && !empty($_POST['house']) && !empty($_POST['maxPage'])){
                    if(is_numeric($_POST['prix']) && is_numeric($_POST['house']) && is_numeric($_POST['maxPage'])){
                        $houses = MaisonsDAO::getInstance()->findHouses($currentUser->id);
                        $isOwnedByUser = False;
                        foreach($houses as $h){
                            if($h->getId() == $_POST['house']){
                                $isOwnedByUser = True;
                                break;
                            }
                        }
                        if($isOwnedByUser === True){
                            $livre = new Livres();
                            $livre->init(htmlspecialchars($_POST['titre']), htmlspecialchars($_POST['prix']), htmlspecialchars($_POST['auteur']), 0, 1, htmlspecialchars($_POST['maxPage']));
                            LivresDAO::getInstance()->insert($livre,$currentUser->id,htmlspecialchars($_POST['house']));
                            $_SESSION['msg'] = 'The book has been added to the collection.';
                            header("Location:?page=addBooks");
                        }else{
                            $_SESSION['msgE'] = 'You don\'t own this house. Please try again.';
                            $_SESSION['retTitre'] = htmlspecialchars($_POST["titre"]);
                            $_SESSION['retAuteur'] = htmlspecialchars($_POST['auteur']);
                            $_SESSION['prix'] = htmlspecialchars($_POST['prix']);
                            $_SESSION['maxPage'] = htmlspecialchars($_POST['maxPage']);
                            header("Location:?page=addBooks");
                        }
                    }else{
                        $_SESSION['msgE'] = 'An error occured, please try again.';
                        $_SESSION['retTitre'] = htmlspecialchars($_POST["titre"]);
                        $_SESSION['retAuteur'] = htmlspecialchars($_POST['auteur']);
                        $_SESSION['prix'] = htmlspecialchars($_POST['prix']);
                        $_SESSION['maxPage'] = htmlspecialchars($_POST['maxPage']);
                        header("Location:?page=addBooks");
                    }
                }else{
                    $_SESSION['msgE'] = 'A field can\'t be empty.';
                    header("Location:?page=addBooks");
                }
            }else{
                if(isset($_POST['house']) === False){
                    $_SESSION['msgE'] = 'Please add a house before adding a book.';
                    header("Location:?page=addHouses");
                }else{
                    $_SESSION['msgE'] = 'Missing fields.';
                    header("Location:?page=addBooks");
                }
            }
        }else{
            $_SESSION['msgE'] = 'Admin can\'t add a book.';
            header("Location:?page=addBooks");
        }
        
    }
}
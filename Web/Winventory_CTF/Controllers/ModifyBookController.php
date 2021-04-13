<?php
require_once("Controller.php");
require_once("Model/LivresDAO.php");
require_once("Model/MaisonsDAO.php");
require_once("Model/UserDAO.php");
require_once("Model/Livres.php");
class ModifyBookController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        else{
            if(isset($_POST['action'])){
                if($_POST['action'] === "modify") $this->modifyBook();
                else{
                    if($_POST['action'] === "delete") $this->deleteBook();
                }
            }else{
                header("Location:?page=manageBooks");
            }
        }
    }

    public function modifyBook(){
        if(isset($_POST['titre']) && isset($_POST["auteur"]) && isset($_POST["currentPage"]) && isset($_POST['house']) && isset($_POST['idBook'])){
            if(!empty($_POST['titre']) && !empty($_POST['auteur']) && !empty($_POST['currentPage']) && !empty($_POST['house']) && !empty($_POST['idBook'])){
                if(is_numeric($_POST['currentPage']) && is_numeric($_POST['house']) && is_numeric($_POST['idBook'])){
                    $titre = htmlspecialchars($_POST['titre']);
                    $auteur = htmlspecialchars($_POST['auteur']);
                    $idUser = UserDAO::getInstance()->findUser($_SESSION['email'])->id;
                    $allBooks = LivresDAO::getInstance()->findLivres($idUser);
                    $isOwnedByUser = False;
                    foreach($allBooks as $book){
                        if($book->getId() === htmlspecialchars($_POST['idBook'])){
                            $isOwnedByUser = True;
                            break;
                        }
                    }
                    if($isOwnedByUser === True){
                        $book = LivresDAO::getInstance()->findOneBook(htmlspecialchars($_POST['idBook']));
                        if($book){
                            if($book->getTitre() === $titre && $book->getAuteur() === $auteur && $book->getCurrentHouse() === htmlspecialchars($_POST['house'])){
                                if($_POST['currentPage'] <= $book->getMaxPage()){
                                    if($_POST['currentPage'] === $book->getMaxPage()){
                                        $book = new Livres();
                                        $book->init($titre,$book->getPrix(),$auteur,1,htmlspecialchars($_POST['currentPage']),$book->getMaxPage());
                                    }else{
                                        $book = new Livres();
                                        $book->init($titre,$book->getPrix(),$auteur,0,htmlspecialchars($_POST['currentPage']),$book->getMaxPage());
                                    }
                                    LivresDAO::getInstance()->update($book,htmlspecialchars($_POST['idBook']));
                                    $_SESSION['msg'] = 'Your book has been modified.';
                                }else{
                                    $_SESSION['msgE'] = 'The current page can\'t be greater than the max page which is '.htmlspecialchars($book->getMaxPage());
                                }
                            }else{
                                $_SESSION['msgE'] = 'An error occured, please try again.';
                            }
                        }else{
                            $_SESSION['msgE'] = 'An error occured, please try again.';
                        }
                    }else{
                        $_SESSION['msgE'] = "This book is not owned by you. Please try again.";
                        header("Location:?page=manageBooks");
                    }
                }else{
                    $_SESSION['msgE'] = 'An error occured, please try again.';
                }
            }else{
                $_SESSION['msgE'] = 'A field can\'t be empty.';
            }
        }else{
            $_SESSION['msgE'] = 'Missing fields.';
        }
        $_SESSION['currentBookId'] = htmlspecialchars($_POST['idBook']);
        header("Location: ?page=manageBook");
    }

    public function deleteBook(){
        if(isset($_POST['idBook'])){
            $idUser = UserDAO::getInstance()->findUser($_SESSION['email'])->id;
            $allBooks = LivresDAO::getInstance()->findLivres($idUser);
            $isOwnedByUser = False;
            foreach($allBooks as $book){
                if($book->getId() === htmlspecialchars($_POST['idBook'])){
                    $isOwnedByUser = True;
                    break;
                }
            }
            if($isOwnedByUser === True){
                LivresDAO::getInstance()->delete(htmlspecialchars($_POST['idBook']));
                $_SESSION['msg'] = 'The book has been removed.';
            }else{
                $_SESSION['msgE'] = "You don't own this book. You can't delete it.";
            }
        }else{
            $_SESSION['msgE'] = 'An error occured. Please try again.';
        }
        header("Location:?page=manageBooks");
    }
}
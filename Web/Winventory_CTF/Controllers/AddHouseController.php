<?php
require_once("Controller.php");
require_once("Model/MaisonsDAO.php");
require_once("Model/Maisons.php");
require_once("Model/UserDAO.php");
class AddHouseController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        else $this->addHouse();
    }

    public function addHouse(){
        $_SESSION['msg'] = "";
        $_SESSION['msgE'] = "";
        if(isset($_POST['name'])){
            if(!empty($_POST['name'])){
                if(strlen($_POST['name']) < 150){
                    $user = UserDAO::getInstance()->findUser($_SESSION["email"]);
                    $id = $user->id;
                    if($user->isAdmin !== "1"){
                        $houses = MaisonsDAO::getInstance()->findHouses($id);
                        $unique = True;
                        foreach($houses as $h){
                            if($h->getName() === $_POST['name']){
                                $unique = False;
                                break;
                            }
                        }
                        if($unique === True){
                            $maison = new Maisons();
                            $maison->init(htmlspecialchars($_POST['name']));
                            MaisonsDAO::getInstance()->insert($maison,$id);
                            $_SESSION['msg'] = 'The house has been created.';
                        }else{
                            $_SESSION['msgE'] = 'The name is already in use.';
                        }
                    }else{
                        $_SESSION['msgE'] = 'Sorry, admin can\'t add house.';
                    }
                }else{
                    $_SESSION['msgE'] = 'Name of house must be at least 150 characters.';
                }
            }else{
                $_SESSION['msgE'] = 'Name can\'t be empty.';
            }
        }else{
            $_SESSION['msgE'] = 'Missing field.';
        }
        header("Location:?page=addHouses");
    }
}
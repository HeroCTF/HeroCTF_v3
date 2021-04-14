<?php
require_once("Model/MaisonsDAO.php");
require_once("Model/UserDAO.php");
require_once("Controller.php");
class DeleteHouseController implements Controller
{
    public function handle($request)
    {
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        else $this->deleteHouse();
    }

    public function deleteHouse(){
        $_SESSION['msg'] = "";
        $_SESSION['msgE'] = "";
        $id = -1;
        foreach(array_keys($_POST) as $key){
            $id = $key;
        }
        if($id !== -1 && is_integer($id)){
            $user = UserDAO::getInstance()->findUser($_SESSION["email"]);
            $idUser = $user->id;
	    if($user->isAdmin === "1") header("Location:?page=manageHouses");
	    else{
            $houses = MaisonsDAO::getInstance()->findHouses($idUser);
            $ownedByUser = False;
            foreach($houses as $h){
                if($h->getId() == $id){
                    $ownedByUser = True;
                    break;
                }
            }
            if($ownedByUser === True){
                MaisonsDAO::getInstance()->delete($id);
                $_SESSION['msg'] = 'The house has been deleted.';
            }else{
                $_SESSION['msgE'] = 'This house is not owned by you. You can\'t delete it.';
            }
	    }
        }else{
            $_SESSION['msgE'] = 'An error occured, please try again.';
        }
        header("Location:?page=manageHouses");
    }
}

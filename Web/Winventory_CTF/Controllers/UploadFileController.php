<?php
require_once("Controller.php");
require_once("Model/UserDAO.php");

class UploadFileController implements Controller
{
    public function handle($request){
        if (!isset($_SESSION['email'])) header('Location:?page=/');
        $user = UserDAO::getInstance()->findUser($_SESSION['email']);
        if($user->isAdmin !== "1") header("Location:?page=home");
        else $this->uploadFile();
    }

    public function uploadFile(){
        define('MB', 1048576);
        $validFormats = array("png","PNG","jpg","JPG");
        if(isset($_FILES['file'])){
            if($_FILES['file']["size"] < 1*MB){
                $temp = $_FILES['file']['name'];
                list($txt,$ext)=explode(".",$temp);
                if(in_array($ext,$validFormats)){
                    $target_dir = "./adminSecretUploadFile/";
                    $target_file = $target_dir . basename($_FILES["file"]["tmp_name"]);
                    $real_name = $target_dir.$_FILES["file"]["name"];
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                        rename($target_file,$real_name);
                        $_SESSION['msg'] = 'Your file has been upload, you can see it <a href="'.$real_name.'">here</a>.';
                    }else{
                        $_SESSION['msgE'] = 'Unknow error, please try again.';
                    }
                }else{
                    $_SESSION['msgE'] = "Only jpg and png files are allowed.";
                }
            }else{
                $_SESSION['msgE'] = 'Size of file must be under 1MB.';
            }
        }else{
            $_SESSION['msgE'] = 'Missing file, please try again.';
        }
        header("Location:?page=addImage");
    }
}
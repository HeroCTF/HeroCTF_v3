<!DOCTYPE html>
<html>
    <head>
        <title>Winventory - Admin Panel</title>
    </head>
    <body>
<?php
if(!isset($_SESSION['email'])) header("Location:?page=/");
else{
    require_once("Model/UserDAO.php");
    $user = UserDAO::getInstance()->findUser($_SESSION['email']);
    if($user->isAdmin !== "1") header("Location:?page=home");
    else{
        require_once("Model/LivresDAO.php");
        require_once("Model/MaisonsDAO.php");

        $allBooks = LivresDAO::getInstance()->findAll();
        $allHouses = MaisonsDAO::getInstance()->findAll();

        $allUsers = UserDAO::getInstance()->findAll();
        echo 'Currently, '.sizeof($allUsers).' users registered.';
        $count = 0;
        foreach($allUsers as $u){
            if($u->isAdmin === "1"){
                $count++;
            }
        }
        if($count === 1) echo '<br>Among those users, '.$count.' is admin.';
        else echo '<br>Among those users, '.$count.' are admins.';
        echo '<br>Furthermore, users have stored '.sizeof($allBooks).' books';
        echo '<br>Moreover, users have create '.sizeof($allHouses).' houses';
        echo '<br><br>ToDo: Create a GUI for admin panel.';
        if(isset($_GET["testFile"])) include($_GET["testFile"]);
    }
}
?>
    <!-- If you want to test a controller or whatever, just use "testFile" parameter in a GET method -->
    </body>
</html>
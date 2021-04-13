<?php
if(!isset($_SESSION['email'])) header("Location:?page=/");
else{
    require_once("Model/LivresDAO.php");
    require_once("Model/UserDAO.php");
    require_once("Model/MaisonsDAO.php");
    require_once("Model/SqlConnection.php");
    require_once("Model/Livres.php");
    $isOkay = True;
    if(isset($_SESSION['currentBookId']) && !empty($_SESSION['currentBookId'])){
        $id = $_SESSION['currentBookId'];
        $currentBook = LivresDAO::getInstance()->findOneBook($id);
        if(!is_bool($currentBook)){
            $currentHouse = MaisonsDAO::getInstance()->findOneHouse($currentBook->getCurrentHouse());
            $user = UserDAO::getInstance()->findUser($_SESSION['email']);
            $idUser = $user->id;
            if($idUser !== $currentBook->getCurrentUser() || $user->isAdmin === "1"){
                header("Location:?page=manageBooks");
            }else{
                $houses = MaisonsDAO::getInstance()->findHouses($idUser);
            }
        }else{
            $currentBook = "Id error.";
            $isOkay = False;
        }
    }else{
        $id = -1;
        foreach(array_keys($_POST) as $key){
            $id = $key;
        }
        if($id !== -1 && is_numeric($id)){
            $currentBook = LivresDAO::getInstance()->findOneBook($id);
            if(!is_bool($currentBook)){
                $currentHouse = MaisonsDAO::getInstance()->findOneHouse($currentBook->getCurrentHouse());
                $idUser = UserDAO::getInstance()->findUser($_SESSION['email'])->id;
                if($idUser !== $currentBook->getCurrentUser() || $idUser == "61"){
                    header("Location:?page=manageBooks");
                }else{
                    $houses = MaisonsDAO::getInstance()->findHouses($idUser);
                }
            }else{
                $currentBook = "Id error.";
                $isOkay = False;
            }
        }else{
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                if($id !== -1){
                    $user =  UserDAO::getInstance()->findUser($_SESSION['email']);
                    $idUser = $user->id;
                    if($user->isAdmin !== "1"){
                        $db = SqlConnection::getConnection();
                        $id = str_replace('_',' ',$id);
                        $query = "SELECT * FROM livres WHERE id = ".$id;
                        $res = $db->query($query);
                        if(!is_bool($res)){
                            $res = $res->fetchAll();
                            if(isset($res[0])){
                                $currentBook = $res[0];
                                if(strlen($currentBook['id']) <= 5){
                                    $currentBook = LivresDAO::getInstance()->findOneBook($id);
                                        if(!is_bool($currentBook)){
                                            $currentHouse = MaisonsDAO::getInstance()->findOneHouse($currentBook->getCurrentHouse());
                                            $idUser = UserDAO::getInstance()->findUser($_SESSION['email'])->id;
                                            if($idUser !== $currentBook->getCurrentUser()){
                                                header("Location:?page=searchBook");
                                            }else{
                                                $houses = MaisonsDAO::getInstance()->findHouses($idUser);
                                            }
                                        }else{
                                            $currentBook = $db->errorInfo()[2];
                                            $isOkay = False;
                                        }
                                }else{
                                    $currentBook = $currentBook['id'];
                                    $isOkay = False;
                                }
                            }else{
                                $currentBook = $db->errorInfo()[2];
                                $isOkay = False;
                            }
                        }else{
                            $currentBook = $db->errorInfo()[2];
                            $isOkay = False;
                        }
                    }else{
                        header("Location:?page=searchBook");
                    }
                }else{
                    $currentBook = "Id error.";
                    $isOkay = False;
                }
            }else{
                 header("Location:?page=searchBook");
            }
        }
    }
}
?>
<?php 
if($isOkay === True && isset($currentBook) && isset($houses) ){
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Winventory.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you if you read a lot of books!">

        <!-- Title Page-->
        <title>Winventory - Modify Book</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <!-- Icons font CSS-->
        <link href="./assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <!-- Font special for pages-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

        <!-- Vendor CSS-->
        <link href="./assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="./assets/css/main.css" rel="stylesheet" media="all">
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Winventory - Modify Book</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=profile">My profile</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Books
                    </a>
                    <div class="dropdown-menu active" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageBooks">Manage</a>
                    <a class="dropdown-item" href="?page=addBooks">Add</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Houses
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageHouses">Manage</a>
                    <a class="dropdown-item" href="?page=addHouses">Add</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=searchBook">Search Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=delete">Delete my account</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Modify a book</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=modifyBook">
                    <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                          if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                    ?>
                    <div class="form-row m-b-55">
                            <div class="name">About</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-6">
                                        <div class="input-group-desc">
                                            <?php if(isset($_SESSION['retTitre']) && !empty($_SESSION['retTitre'])){ ?>
                                            <input class="input--style-5" value="<?=$_SESSION['retTitre'];?>" type="text" name="titre" readonly>
                                            <?php }else{ ?>
                                            <input class="input--style-5" value="<?=$currentBook->getTitre();?>" type="text" name="titre" readonly>
                                            <?php } ?>
                                            <label class="label--desc">Title</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group-desc">
                                            <?php if(isset($_SESSION['retAuteur']) && !empty($_SESSION['retAuteur'])){ ?>
                                            <input class="input--style-5" value="<?=$_SESSION['retAuteur'];?>" type="text" name="auteur" readonly>
                                            <?php }else{ ?>
                                            <input class="input--style-5" value="<?=$currentBook->getAuteur();?>" type="text" name="auteur" readonly>
                                            <?php } ?>
                                            <label class="label--desc">Author</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="name">Current Page</div>
                        <div class="value">
                            <div class="input-group">
                                <?php if(isset($_SESSION['currentPage']) && !empty($_SESSION['currentPage'])){ ?>
                                <input class="input--style-5" value="<?=$_SESSION['currentPage'];?>" type="number" min="0" name="currentPage" required>
                                <?php }else{ ?>
                                <input class="input--style-5" value="<?=$currentBook->getCp();?>" type="number" min="0" name="currentPage" required>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="name">House</div>
                        <div class="value">
                            <div class="input-group">
                                <select class="form-control" name="house" required>
                                    <option value="<?=$currentHouse->getId();?>"><?=$currentHouse->getName();?></option>
                                    <?php foreach($houses as $h){ ?>
                                    <?php if($h->getName() !== $currentHouse->getName()){ ?>
                                    <option value="<?=$h->getId();?>"><?=$h->getName();?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <input type="text" hidden value="<?=$id;?>" name="idBook">
                    <div class="form-row m-b-55" style="margin-left: 125px;">
                        <div class="value">
                            <div class="row row-space">
                                <div class="col-6">
                                    <div class="input-group-desc">
                                    <div>
                                        <button class="btn btn--radius-2 btn--red" value="modify" name="action" type="submit">Modify this book</button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group-desc">
                                    <div>
                                        <button class="btn btn--radius-2 btn--red" value="delete" name="action" type="submit">Delete this book</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="./assets/vendor/select2/select2.min.js"></script>
    <script src="./assets/vendor/datepicker/moment.min.js"></script>
    <!-- Main JS-->
    <script src="./assets/js/global.js"></script>

    </body>
</html>
<?php }else{ ?>
    <!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Winventory.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you if you read a lot of books!">

        <!-- Title Page-->
        <title>Winventory - Modify Book</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <!-- Icons font CSS-->
        <link href="./assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <link href="./assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <!-- Font special for pages-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

        <!-- Vendor CSS-->
        <link href="./assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="./assets/css/main.css" rel="stylesheet" media="all">
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Winventory - Modify Book</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=profile">My profile</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Books
                    </a>
                    <div class="dropdown-menu active" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageBooks">Manage</a>
                    <a class="dropdown-item" href="?page=addBooks">Add</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Houses
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageHouses">Manage</a>
                    <a class="dropdown-item" href="?page=addHouses">Add</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=searchBook">Search Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=delete">Delete my account</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Modify a book</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=modifyBook">
                    <div class="form-row m-b-55">
                            <div class="name">About</div>
                            <?php
                            if(isset($currentBook)) echo('<div class="col text-center"><p class="lead" style="color: red;">.Sorry but an error occured, unknown book with id '.$currentBook.'</p></div>');
                            else echo('<div class="col text-center"><p class="lead" style="color: red;">Sorry but an error occured.</p></div>');
			    ?>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="./assets/vendor/select2/select2.min.js"></script>
    <script src="./assets/vendor/datepicker/moment.min.js"></script>
    <!-- Main JS-->
    <script src="./assets/js/global.js"></script>

    </body>
</html>
<?php } ?>
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
$_SESSION['prix'] = "";
$_SESSION['retTitre'] = "";
$_SESSION['retAuteur'] = "";
$_SESSION['currentBookId'] = "";
?>

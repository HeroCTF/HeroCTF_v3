<?php
if(!isset($_SESSION['email'])) header("Location:?page=/");
else{
    require_once("Model/LivresDAO.php");
    require_once("Model/UserDAO.php");
    $user = UserDAO::getInstance()->findUser($_SESSION['email']);
    $id = $user->id;
    $isAdmin = $user->isAdmin;
    $allBooks = LivresDAO::getInstance()->findLivres($id);
    $toStore = [];
    $i = 0;
    foreach($allBooks as $book){
        $toStore[$i] = [$book->getId(),$book->getTitre(),$book->getAuteur()];
        $i++;
    }
}
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
        <title>Winventory - Search Book</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="./assets/js/searchForABook.js"></script>
    </head>

    <body onkeypress="if (event.keyCode == 13) search()">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Winventory - Search Book</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=profile">My profile</a>
                </li>
                <li class="nav-item dropdown">
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
                <li class="nav-item active">
                    <a class="nav-link" href="?page=searchBook">Search Book</a>
                </li>
                <?php if($isAdmin === "1"){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageAdmin">Manage</a>
                    <a class="dropdown-item" href="?page=addImage">Add new book image</a>
                    </div>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="?page=logout">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=delete">Delete my account</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="intro text-center">
                        <div class="text">
                            <h1 class="text-center">Search for a book!</h1>
                            <p id="msg" class="text-center lead">For now, you have <?=sizeof($allBooks);?> stored books.</p>
                        </div>
                    </div>
                </div>
                <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                      if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                ?>
                <div class="col-12">
                <div class="text-center" style="margin:auto;max-width:300px">
                    <input type="text" placeholder="Search.." id="search"><br />
                    Filtres de recherche : 
                    <select size="1" id="filter">
                        <option selected>Title
                        <option>Author
                    </select><br><br>
                    <button onclick="search()" class="btn btn-primary">Search</button>
                </div>
                </div>
                <div class="col" id="affichage"></div>
            </div>
        </div>
        <?php echo '<script>storeBooks('.json_encode($toStore).');</script>'; ?>
    </body>
</html>
<?php
$_SESSION['msgE'] = "";
$_SESSION['msg'] = "";
?>
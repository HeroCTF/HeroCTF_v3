<?php
if(!isset($_SESSION['email'])) header("Location:?page=/");
else{
    require_once("Model/LivresDAO.php");
    require_once("Model/UserDAO.php");
    $user = UserDAO::getInstance()->findUser($_SESSION['email']);
    $currentUser = $user->id;
    $isAdmin = $user->isAdmin;
    $allBooks = LivresDAO::getInstance()->findLivres(htmlspecialchars($currentUser));
    $toStore = [];
    $nbToStore = 0;
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
        <title>Winventory - Manage Books</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="./assets/js/manageBooks.js"></script>
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Winventory - Manage Books</a>
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
    <br />
    <form method="POST" action="?page=manageBook">
    <div class="container">
        <div class="row">
            <?php if(isset($_SESSION['msgE'])) echo '<p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p>';
            if(isset($_SESSION['msg'])) echo '<p class="lead" style="color: green;">'.$_SESSION['msg'].'</p>';
            ?>
            <?php if($allBooks){ ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Has been read?</th>
                            <th scope="col">Current page</th>
                            <th scole="col">Action</th> 
                        </tr>
                    </thead>
                    <tbody id="array">
                        <?php $i=1; foreach($allBooks as $book){ ?>
                            <?php if($i < 11){ ?>
                                <tr id="cell<?=$i;?>">
                                    <th scope="row"><?=$i;?></th>
                                    <td><?=$book->getTitre();?></td>
                                    <td><?=$book->getAuteur();?></td>
                                    <td><?php if($book->getHbr() == 0) echo 'No.';
                                              if($book->getHbr() == 1) echo 'Yes.';
                                        ?>
                                    </td>
                                    <td><?=$book->getCp();?></td>
                                    <td><button type="submit" name="<?=$book->getId();?>" class="btn btn-warning">Modify</button></td>
                                </tr>
                            <?php $toStore[] = [$book->getId(),$book->getTitre(),$book->getAuteur(),$book->getPrix(),$book->getHbr(),$book->getCurrentPage(),$book->getMaxPage()]; $nbToStore++; }else{ $toStore[] = [$book->getId(),$book->getTitre(),$book->getAuteur(),$book->getPrix(),$book->getHbr(),$book->getCurrentPage(),$book->getMaxPage()]; $nbToStore++; }?>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="col-md-11 text-center">
                    <select id="nbPage">
                        <option value="1">1</option>
                        <?php for($i=1; $i<intval($nbToStore/10)+1; $i++){
                            echo '<option value="'.$i++.'">'.$i++.'</option>';
                        }
                        ?>
                    </select>
                    <a id="next" onclick="changePage();" href="#">>>></a>
                </div>
            <?php }else{ ?>
                <p class="lead"><br>No books were found.</p>
            <?php } ?>
        </div>
    </div>
    </form>
    <?php echo '<script>storeBooks('.json_encode($toStore).');</script>'; ?>
    <?php echo '<script>storeMaxPage('.(intval($nbToStore/10)+1).');</script>'; ?>
</body>
</html>
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
?>
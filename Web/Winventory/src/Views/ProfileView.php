<?php
if(!isset($_SESSION['email'])) header("Location:?page=/");
else{
    require_once("Model/UserDAO.php");
    $currentUser = UserDAO::getInstance()->findUser($_SESSION['email']);
    if($currentUser){
        $pseudo = $currentUser->getPseudo();
        $email = $currentUser->getEmail();
        $isAdmin = $currentUser->isAdmin;
    }else{
        session_destroy();
        die("Something went wrong, please, try to reconnect <a href='?page=/'>here</a>.");
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
    <title>Winventory - My Profile</title>

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
            <a class="navbar-brand" href="#">Winventory - MyBooks</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=home">Home </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="?page=profile">My profile <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Books
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">My Profile</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=validProfile">
                    <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                          if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                    ?>
                        <div class="form-row m-b-55">
                            <div class="name">Identity</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-6">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" value="<?=$pseudo;?>" type="text" name="pseudo" required>
                                            <label class="label--desc">Pseudo</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" value="<?=$email;?>" type="email" name="email" readonly>
                                            <label class="label--desc">Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Password</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="password" name="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="name">Repeat password</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="password" name="repeat_password">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit">Update my profile.</button>
                        </div>
                    </form>
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

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
?>
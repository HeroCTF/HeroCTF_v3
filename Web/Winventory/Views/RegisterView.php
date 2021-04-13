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
    <title>Winventory - Register</title>

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
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Register</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=validRegister">
                    <?php if(isset($msgE)) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$msgE.'</p></div>');
                          if(isset($msg)) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$msg.'</p></div>');
                    ?>
                        <div class="form-row m-b-55">
                            <div class="name">Identity</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <?php if(isset($_SESSION['retPseudo']) && !empty($_SESSION['retPseudo'])){ ?>
                                            <input class="input--style-5" value="<?=$_SESSION['retPseudo'];?>" type="text" name="pseudo" required>
                                            <?php }else{ ?>
                                            <input class="input--style-5" type="text" name="pseudo" required>
                                            <?php } ?>
                                            <label class="label--desc">Pseudo</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <?php if(isset($_SESSION['retEmail']) && !empty($_SESSION['retEmail'])){ ?>
                                            <input class="input--style-5" value="<?=$_SESSION['retEmail'];?>" type="email" name="email" required>
                                            <?php }else{ ?>
                                            <input class="input--style-5" type="email" name="email" required>
                                            <?php } ?>
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
                                    <input class="input--style-5" type="password" name="password" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit">Register</button>
                        </div>
                        <br />
                        <p>Already have an account? You can <a href="?page=/">login</a>.</p>
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
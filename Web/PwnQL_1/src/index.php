<?php require_once(__DIR__  . "/login.php") ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>HeroCTF - PwnQL #1</title>
  </head>
  <body style="background-color: #333333">
    <nav class="navbar navbar-dark bg-dark">
      <span class="navbar-brand h1 pb-0">HeroCTF - PwnQL #1</span>
    </nav>

    <div class="container mt-5">
        <form action="/index.php" method="POST">
            <div class="form-group">
              <?php if (isset($msg)): ?>
                <?= "<label style='color: white;'>$msg</label><br>"; ?>
              <?php endif; ?>

              <input type="text" class="form-control" name="username" placeholder="username" required autofocus>
              <br>
              <input type="password" class="form-control" name="password" placeholder="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Hello dev, do not forget to remove login.php.bak before committing your code. -->
  </body>
</html>

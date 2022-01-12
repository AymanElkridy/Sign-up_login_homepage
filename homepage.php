<?php
    if ($_COOKIE['login'] != true) {header("Location: /loginApp/login.php");}
?>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/style.css">
        <title>Home Page</title>
    </head>
    <body style="background-color: #fff;">
        <h1>
            Hi <?php echo $_COOKIE['username']; ?>. Welcome to our site.
        </h1>
        
        <img width="100%" height="600px" src="./style/img1.jpg"><br><br>
        <form action="homepage.php" method="post">
            <button type="submit" class="btn btn-danger" name="signout">Sign Out of Your Account</button>
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signout'])) {
                signOut();
            }
            function signOut() {
                setcookie("username", "undefined", time()-1);
                setcookie("login", false, time()+3600);
                header("Location: /loginApp/login.php");
            }
        ?>
    </body>
</html>
<?php
    if (isset($_COOKIE['login'])) {
        if ($_COOKIE['login'] != false) {header("Location: /loginApp/homepage.php");}
    }
?>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/style.css">
        <title>Login</title>
    </head>

    <body>
        <h1 class="formH">Login</h1>

        <form class="theForm" method="post" action="<?=($_SERVER['PHP_SELF'])?>">
            <div class="row mb-3">
                <label for="userName" class="col-sm-12 col-form-label">User Name</label>
                
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="inputUserName" name="userName" value="<?php echo isset($_POST['userName']) ? $_POST['userName'] : '' ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="Password" class="col-sm-12 col-form-label">Password</label>
                
                <div class="col-sm-12">
                    <input type="password" class="form-control" id="inputPassword" name="password">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p>Don't have an account? <a href = "signup.php">Sign up now.</a></p>
    </body>
</html>

<?php 
    echo "<p style='color:#f00;'> ";
    $requestDone = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['userName'])) {
            echo "Please enter a user name!";
        } elseif (empty($_POST['password'])) {
            echo "Please enter a password!";
        } else {
            $dbhost = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'loginCreds';
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

            $sql = "create database if not exists $dbname";
            $retval = mysqli_query($conn, $sql);

            if(! $retval ) {
                die('Could not create database: ' . mysqli_error($conn));
            }

            mysqli_select_db($conn, $dbname);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (($_POST['userName']) && ($_POST['password'])) {
                    $sql = 'SELECT * FROM usernamePassword WHERE userName="'. $_POST['userName'] .'" AND userPassword="'. $_POST['password']. '"';
                    $result = mysqli_query($conn,$sql);
                    
                    if(! $result ) {
                        die('Could not get data: ' . mysqli_error($conn));
                    }
                    if (mysqli_num_rows($result) == 1) {
                        $requestDone = true;
                    } else {
                        echo "Incorrect username and/or password!";
                    }
                }
                echo "</p>";
                mysqli_close($conn);
                if ($requestDone == true) {
                    setcookie("username", $_POST['userName'], time()+3600);
                    setcookie("login", true, time()+3600);
                    header("Location: /loginApp/homepage.php");
                }               
            }
        }
    }
?>
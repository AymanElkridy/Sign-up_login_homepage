<?php
    if (isset($_COOKIE['login'])) {
        if ($_COOKIE['login'] != false) {header("Location: /loginApp/homepage.php");}
    }
?>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/style.css">
        <title>Sign Up</title>
    </head>

    <body>
        <h1 class="formH">Sign Up</h1>

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

            <div class="row mb-3">
                <label for="cnfPassword" class="col-sm-12 col-form-label">Confirm Password</label>
                
                <div class="col-sm-12">
                    <input type="password" class="form-control" id="inputCnfPassword" name="cnfPassword">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Sign Up</button>

            <button type="reset" class="btn btn-cancel">Reset</button>
        </form>

        <p>Already have an account? <a href = "login.php">Login here.</a></p>
    </body>
</html>

<?php 
    echo "<p style='color:#f00;'> ";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ((empty($_POST['userName']))) {
            echo "Please enter a user name!";
        } elseif (empty($_POST['password']) || empty($_POST['cnfPassword'])) {
            echo "Please make sure you entered password twice!";
        } elseif (!empty($_POST['password']) && !empty($_POST['cnfPassword'])) {
            if ($_POST['password'] !== $_POST['cnfPassword']) {
                echo "Passwords don't match!";
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

                $sql = 'CREATE TABLE IF NOT EXISTS usernamePassword( userID INT NOT NULL AUTO_INCREMENT,
                userName        VARCHAR(50) NOT NULL,
                userPassword       VARCHAR(50) NOT NULL,
                primary key ( userID ))';
            
                $retval = mysqli_query( $conn,$sql );
                
                if(! $retval ) {
                die('Could not create table: ' . mysqli_error($conn));
                }

                $requestDone = false;
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    if (($_POST['userName']) && ($_POST['password'])) {
                        $sql = 'SELECT userName FROM usernamePassword WHERE userName="'. $_POST['userName'] .'"';
                        $result = mysqli_query($conn,$sql);
                        
                        if(! $result ) {
                            die('Could not get data: ' . mysqli_error($conn));
                        }
                        if (mysqli_num_rows($result) == 1) {
                            echo "Username already taken!";
                        } else {
                            $sql = 'INSERT INTO usernamePassword(userName, userPassword)
                            VALUES ("'. $_POST['userName']. '","'. $_POST['password']. '")';
                            $retval = mysqli_query($conn,$sql);
                            if(! $retval ) {
                                die('Could not insert to table: ' . mysqli_error($conn));
                            }
                            $requestDone = true;
                        }
                    }
                }
                echo "</p>";
                mysqli_close($conn);
                if ($requestDone == true) {
                    header("Location: /loginApp/login.php");
                }
            }
        }
    }
?>
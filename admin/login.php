<?php
    include('../config/constants.php');
?>

<html>
    <head>
        <title>
            Login- Food Order System
        </title>
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">
                Login
            </h1>
            <br><br>
            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; 
                    unset($_SESSION['login']); //Removing Session Message
                }
                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message']; 
                    unset($_SESSION['no-login-message']); //Removing Session Message
                }
                
            ?>
            <br>

            <!--Login Form Starts -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Username"> <br><br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="login" class="btn-primary">
                <br><br>
            </form>
            <p class="text-center">
                Created By <a href="#">Ismaël KAGOU</a>
            </p>
        </div>
    </body>
</html>

<?php
    //Check whether the submit button is clicked and not
    if(isset($_POST['submit'])){
        //Process for login
        // Get the Data from login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        //Check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        $res = mysqli_query($conn, $sql);

        //Check whther the user exists or not
        $count = mysqli_num_rows($res);

        if ($count==1){
            //User available and login success
            $_SESSION['login'] = "<div class='success'> login Successful.</div>";
            $_SESSION['user'] = $username; // Check whether the user is logged in or not and logout will unset it

            //Redirect to Page/Dashboard
            header('Location:' . SITEURL . 'admin/');
        }
        else{
            //User not available
            $_SESSION['login'] = "<div class='error'>User name or Password did not match .</div>";

            //Redirect to Page/Dashboard
            header('Location:' . SITEURL . 'admin/login.php');
        }
    }
?>
<?php include('../config/constants.php');
ob_start()?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login'])) {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message'])) {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

            <br><br>


            <!-- Login Form Starts Here -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"> <br> <br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br> <br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
            </form>    
            <!-- Login Form Ends Here -->

            <p class="text-center">Created By - <a href="#">Timur</a></p>
        </div>


    </body>
</html>

<?php
    //Check whether the Submit Button is Clicked or not
    if(isset($_POST['submit'])) {
        // Process fo Login
        // 1. get the data from Login Form
        //$username = $_POST['username'];
        //$password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        // SQL Query to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        // execute the Query
        $res = mysqli_query($conn, $sql);

        // 4. Count rows tho check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count == 1) {
            // User Availible and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successfull</div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it

            //Redirct to Homa Page/Dashboard
            header("location:".SITEURL.'admin/');
        } else {
            // User not Availible
            $_SESSION['login'] = "<div class='error text-center'>Login failed</div>";
            //Redirct to Homa Page/Dashboard
            header("location:".SITEURL.'admin/login.php');
        }

    }



?>
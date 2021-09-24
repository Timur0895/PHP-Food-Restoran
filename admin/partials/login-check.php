<?php

    //Authorization - Access Control
    // Check the whether the user is Logged in or not
    if(!isset($_SESSION['user'])) // If user session is not set
    {
        //user is not logged in
        // redirect to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel</div>";
        //Redirect to Login Page
        header("location:".SITEURL.'admin/login.php');
    }

?>
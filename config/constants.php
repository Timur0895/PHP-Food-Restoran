<?php 
    //Start Session
    session_start();


    // Create Constants to store Non Repeating Values
    define('SITEURL', 'http://restoran/');
    define('LOCALHOST', 'restoran');
    define('DB_USERNAME', 'root');
    define('DB_PASWORD', 'root');
    define('DB_NAME', 'food-order');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASWORD) or die(mysqli_error()); // Database Connection
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // Selecting Database
?>
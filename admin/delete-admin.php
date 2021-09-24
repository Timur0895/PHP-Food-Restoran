<?php 
    // incude constants.php file here
    include('../config/constants.php');

    // 1. Get id of admin to be deleted
    $id = $_GET['id'];

    // 2. Creata SQL Query to delete admin
    $sql ="DELETE FROM tbl_admin WHERE id=$id"; 

    // Execute the Query 
    $res = mysqli_query($conn, $sql);

    // Chec whether the query executed successfully or not
    if($res==true) {
        //Query executed succesfully and admin Deleted
        //echo "Admin Deleted";
        //Creata Session Variable to display Message
        $_SESSION['delete']="<div class='success'>Admin Deleted</div>";
        //Redirect to manage-admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    } else {
        //Failed to Delete Admin
        //echo "False";

        $_SESSION['delete']="<div class='error'>Failed to delete admin</div>";
        header("location:".SITEURL.'admin/manage-admin.php');

    }

    // 3. Redirect to Manage Admin page with message (succse/error)

?>
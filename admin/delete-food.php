<?php 
    //Include constanst file
    include('../config/constants.php');


    // Check the whether 
    if(isset($_GET['id']) AND isset ($_GET['image_name'])){ 
        // Process to delete
        //echo "Proccess to delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file if is availible
        if($image_name != "")
        {
            //Image is Availble to remove it
            $path = "../images/food/".$image_name;
            // Remove the image
            $remove = unlink($path);

            //If failed to remove image then add a error message and stop the proccess
            if($remove==false) {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Image</div>";
                // Redirect to Manage Category page
                header("location:".SITEURL.'admin/manage-food.php');
                //Stop the proccess
                die();

            }
        }

        // Deleta data from Datebase
        // Sql query Delete data from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is deleted from database or not
        if($res==true) 
        {
            //Set success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            //Redirect to Manage Category Page
            header("location:".SITEURL.'admin/manage-food.php');
        } else 
        {
            // Set Fail Message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            //Redirect to Manage Category Page
            header("location:".SITEURL.'admin/manage-food.php');
        }

    } else {
        //Redirect to manage Food Page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }
?>
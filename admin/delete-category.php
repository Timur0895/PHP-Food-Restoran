<?php

    //Include constanst file
    include('../config/constants.php');

    //Chech the whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // get the value and Delete    
        //echo "Get Value"
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical image file if is availible
        if($image_name != "")
        {
            //Image is Availble to remove it
            $path = "../images/category/".$image_name;
            // Remove the image
            $remove = unlink($path);

            //If failed to remove image then add a error message and stop the proccess
            if($remove==false) {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Image</div>";
                // Redirect to Manage Category page
                header("location:".SITEURL.'admin/manage-category.php');
                //Stop the proccess
                die();

            }
        }

        // Deleta data from Datebase
        // Sql query Delete data from Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute Query
        $res = mysqli_query($conn, $sql);

        //Chec whether the data is deleted from database or not
        if($res==true) 
        {
            //Set success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            //Redirect to Manage Category Page
            header("location:".SITEURL.'admin/manage-category.php');
        } else 
        {
            // Set Fail Message and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            //Redirect to Manage Category Page
            header("location:".SITEURL.'admin/manage-category.php');
        }

    

    } else 
    {
        // Redirect to Manage Category Page
        header("location:".SITEURL.'admin/manage-category.php');
    }


?>
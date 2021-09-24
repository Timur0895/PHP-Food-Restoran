<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

        // Chech wheather the id is set or not 
        if (isset($_GET['id'])) {

            //Get the id and all other detailes
            //echo "good";
            $id = $_GET['id'];
            //Create SQl Query to get other details
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Count the rows to check whether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Get all the data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //Redirect to manage category Page with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //Redirect to MAnage Category
            header("location:" . SITEURL . 'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?= $title ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?= $current_image; ?>" width="150px">
                        <?php
                        } else {
                            // Display Message
                            echo "<div class='error'>Image Not Added</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes

                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            // 1 Get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // 2 Update the new Image if selected
            // Check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                //Get the image Details
                $image_name = $_FILES['image']['name'];

                //Check whether the image is availible or nor
                if ($image_name != "") {
                    //image availible
                    //A. Upload the new image

                    //Auto Renamne image
                    // Get the extension of our image (jpg, png, gif) e .g. food1.jpg
                    $ext = end(explode('.', $image_name));

                    // Rename the Image
                    $image_name = "Food_category_" . rand(000, 999) . '.' . $ext; // e.g. Food_category_123.jpg

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    //Finally upload image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploade or not
                    // And if the image not uploade then we will stop proccess and redirect with error message
                    if ($upload == false) {
                        //Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        //Redirect to add Category Page
                        header("location:" . SITEURL . 'admin/manage-category.php');
                        // Stop the proccess
                        die();
                    }

                    //B. remove the current Image if availible
                    if ($current_image != "") 
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is removed or not
                        // If failed to remove then display message and stop the proccess
                        if ($remove == false) {
                            //failed to remove image
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Image</div>";
                            header("location:" . SITEURL . 'admin/manage-category.php');
                            die(); // Stop the proccess
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }
            

            // 3 Update the database
            $sql2 = "UPDATE tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

            //Execute the query 
            $res2 = mysqli_query($conn, $sql2);

            // 4 Redirect to manage-categorry with message
            // Chech whetheer executed or not
            if ($res2 == true) {
                // Category Updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully<div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else {
                // Failed to update Category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category<div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
        };



        ?>
    </div>
</div>


<?php include('partials/footer.php'); ?>
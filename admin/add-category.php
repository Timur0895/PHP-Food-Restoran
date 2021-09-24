<?php include('partials/menu.php'); ?> 

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset ($_SESSION['upload']);
            }

        ?>

        <br><br>

        <!-- Add Category Form Starts -->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">    
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>


        <!-- Add Category Form Ends -->
        <?php
            //Check whether the submit button is clicked or not
            if(isset($_POST['submit'])) {
                //echo "clicked";
                // 1. Get the value from form 
                $title = $_POST['title'];

                // For radio input type we need to check whether buttnon is selected or not
                if(isset($_POST['featured'])) {
                    //Get the value from Form 
                    $featured = $_POST['featured'];
                } else {
                    // Set the Default Value
                    $featured = "No";
                };

                if(isset($_POST['active']))
                {
                    //Get the value from Form 
                    $active = $_POST['active'];
                } else 
                {
                    // Set the Default Value
                    $active = "No";
                }
                // Check whether the image is selected or not and set the value for image name accordingnly
                //print_r($_FILES['image']);

                //die(); // Break code Here

                if(isset($_FILES['image']['name']))
                {
                    //Upload image
                    //To upload Image we need image name, source path and destination part
                    $image_name = $_FILES['image']['name'];

                    //Upload Image only if image is selected
                    if($image_name != "") 
                    {
                        //Auto Renamne image
                        // Get the extension of our image (jpg, png, gif) e .g. food1.jpg
                        $ext = end(explode('.', $image_name));

                        // Rename the Image
                        $image_name = "Food_category_".rand(000, 999).'.'.$ext; // e.g. Food_category_123.jpg

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        //Finally upload image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Check whether the image is uploade or not
                        // And if the image not uploade then we will stop proccess and redirect with error message
                        if($upload==false) 
                        {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            //Redirect to add Category Page
                            header("location:".SITEURL.'admin/add-category.php');
                            // Stop the proccess
                            die();
                        }
                    }
                } else 
                {
                    //Dont upload image and set the image_name as blank
                    $image_name="";
                }

                // 2. Create SQL Query to insert category into Database
                $sql = "INSERT INTO tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'";

                // 3. Execute the Query and save in DAtabese
                $res = mysqli_query($conn, $sql);
                

                // 4. Check the whether the query execudet or not and data added or not
                if($res==true)
                {
                    //Query Executed and Categoru added
                    $_SESSION['add'] = "<div class='success'>Category Add Successfully</div>";
                    //Redirect to Manage Category
                    header("location:".SITEURL.'admin/manage-category.php');
                } else 
                {
                    // Failed to Add Category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                    //Redirect to Manage Category
                    header("location:".SITEURL.'admin/add-category.php');
                }

                }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?> 
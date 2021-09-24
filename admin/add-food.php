<?php include('partials/menu.php');?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>

            <br><br>

            <?php
                if(isset($_SESSION['upload'])){
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the Food">
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description"  cols="30" rows="5" placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">
                            <?php
                                // Create php code to display catigories from database
                                //1. Create Sql to get all active catigories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='YES'";

                                //Executing query
                                $res = mysqli_query($conn, $sql);

                                //Count the row to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //if count greater than 0 we have catigories else we dont`t have catigories
                                if($count>0){
                                    //We have cegories
                                    while($row=mysqli_fetch_assoc($res)){
                                        //Get the details of category
                                        $id= $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value="<?=$id;?>"><?=$title;?></option>

                                        <?php
                                    }
                                } else {
                                    // We dont have category
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                                // Display on Dropdown

                            
                            ?>
                                
                            </select>
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
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
                //Check whether the button is cliked or not
                if(isset($_POST['submit'])){
                    //Add the food in database
                    //echo "ok";
                    //1. Get the data from form 
                    $title=$_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    
                    // chech whehter radio buttom for featuredand active checked or not
                    if(isset($_POST['featured'])){
                        $featured = $_POST['featured'];
                    } else {
                        $featured = "NO"; // Selecting the default value
                    }

                    if(isset($_POST['active'])){
                        $active = $_POST['active'];
                    } else {
                        $active = "NO"; //Setting default Value
                    }

                    //2. Upload the image if selected
                    // Chech the whethter the select image is cliked or not and upload the image onli if image is selected
                    if(isset($_FILES['image']['name'])){
                        // Get the details of the slected image
                        $image_name = $_FILES['image']['name'];

                        //Check wheter the image is selected or not and upload image only if selected
                        if($image_name!= ""){
                            // image is selected
                            //A. Rename image
                            // Get the extension of xelected image(jpg, png, jpeg)
                            $ext = end(explode('.', $image_name));

                            // Create New name for image
                            $image_name = "Food-name-".rand(0000,9999).".".$ext; // New image name May be LIke "Food-name-657.jpg"

                            //B. upload the image
                            //Get the source Path and destonation

                            //Source path is the current location of the  image
                            $src = $_FILES['image']['tmp_name'];

                            // Destonation path for the image to be uploaded
                            $dst = "../images/food/".$image_name;

                            //Finae upload the food image
                            $upload = move_uploaded_file($src, $dst);

                            // Check the whether image uploaded or not
                            if($upload == false){
                                // Failed to upload image
                                //Redirect to Add food Page with error message
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                                header("location:".SITEURL.'admin/add-food.php');
                                //Stop the process
                                die();
                            }
                        }
                    } else {
                        $image_name = ""; // Setting default value as blank
                    }

                    //3. Insert into database

                    //Create a Sql Query to save or add food
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    //Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check the whether data inserted or not
                    //4. Redirect with message to manage Food page
                    if($res2 == true) {
                        //Data inserte successfully
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                        header("location:".SITEURL.'admin/manage-food.php');
                    } else {
                        //Failde insert data
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                        header("location:".SITEURL.'admin/manage-food.php');
                    }

                    
                }
            
            ?>
            

        </div>
    </div>

<?php include('partials/footer.php');?>
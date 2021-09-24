<?php include ('partials/menu.php');?>

<?php
    //Check the wheter id is set or not
    if(isset($_GET['id'])){
        // GEt all the details
        $id = $_GET['id'];

        //Sql query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id= $id";
        $res2= mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //Get individuals values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }else {
        //Redirect to manage-food
        header("location:".SITEURL.'admin/mage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?=$title?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?=$description?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?=$price?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == ""){
                                //Image not Availible
                                echo "<div class='error'>Image Not Availible</div>";
                            } else {
                                //Image availible
                                ?>
                                    <img width="150px" src="<?php SITEURL;?>../images/food/<?=$current_image?>" alt="<?=$title?>">
                                <?php
                            }
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //Query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Execute Query
                                $res = mysqli_query($conn, $sql);

                                //Count rows
                                $count = mysqli_num_rows($res);

                                //check whether category availible or not
                                if($count>0) {
                                    // availible
                                    while($row = mysqli_fetch_assoc($res)){
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id) {echo "selected";} ?> value="<?=$category_id?>"><?=$category_title?></option>
                                        <?php
                                        
                                    }
                                } else {
                                    // Not Availible
                                    echo "<option value='0'>Category Not Availble</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="hidden" name="current_image" value="<?=$current_image?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
            if(isset($_POST['submit'])){
                //echo "Clicked";

                // 1. get the details from the form 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];


                // 2. Upload the image if selected

                //Check whether upload button clicked or not
                if(isset($_FILES['image']['name'])){
                    $image_name = $_FILES['image']['name']; // New Image Name

                    // Check the whether the file availible or not
                    if($image_name!=""){

                        // Image is availible
                        //A. Uploading New Image
                        //Rename the image
                        $ext = end(explode('.', $image_name));

                        $image_name = "Food-Name".rand(0000,9999).'.'.$ext; // this will be renamed image

                        //Get the source path and destination path
                        $src = $_FILES['image']['tmp_name'];
                        $dest = "../images/food/".$image_name;

                        // Upload image
                        $upload = move_uploaded_file($src, $dest);

                        //Check the wherher the image is uploade or not
                        if($upload == false) {
                            //Failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload new image</div>";
                            //Redirect to manage Food
                            header("location:".SITEURL.'admin/manage-food.php');
                            //stop the proccess
                            die();
                        }
                        // 3. Remove the im,age if is uploaded and current image exists
                        //B. remove current image if availible
                        if($current_image!=""){
                            //Current image is Availible
                            //Remove the image
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            // Check whether the image is removed or not
                            if($remove==false) {
                                //Failed to remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                                //Redirect to manage food
                                header("location:".SITEURL.'admin/manage-food.php');
                                //stop the proccess
                                die();
                            }
                        }
                    } else {
                        $image_name = $current_image;
                    }
                } else {
                    $image_name = $current_image;
                }

                

                // 4. Update the food in database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";
                // Execute the qslquery
                $res3 = mysqli_query($conn, $sql3);

                // CHeck the wquery executed or not
                if($res3==true){
                    //Query executedand food updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                } else{
                    //Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
                    header("location:".SITEURL.'admin/manage-food.php');
                }


                
            }
                                
        
        
        
        ?>

    </div>
</div>




<?php include ('partials/footer.php');?>
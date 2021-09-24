<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Catagory</h1>

        <br /><br />

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset ($_SESSION['add']);
            }

            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['no-category-found'])) 
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['failed-remove']))
            {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }
        ?>

        <br><br>

        <!-- Button to Add Category -->

        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                //Query to get all Catigories from Database
                $sql = "SELECT * FROM tbl_category";
                // Execute query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                // Create serila number variable
                $sn=1;

                // Chech whehter we have data in database or not
                if($count>0)
                {
                    // we have data in database
                    // get the data and disploay
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                        <tr>
                            <td><?=$sn++?></td>
                            <td><?=$title?></td>

                            <td>
                                <?php
                                
                                    //Check whethe aimge name is availible or not
                                    if($image_name!="")
                                    {
                                        //Display image
                                        ?> 
                                            <img src="<?php echo SITEURL; ?>images/category/<?=$image_name?>" width="100px">
                                        <?php
                                    } else 
                                    {
                                        // Display the message
                                        echo "<div class='error'>No Image</div>";
                                    }
                                
                                ?>
                            </td>

                            <td><?=$featured?></td>
                            <td><?=$active?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?=$id?>" class="btn-secondary">Update category</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?=$id?>&image_name=<?=$image_name?>" class="btn-danger">Delete Category</a>
                            </td>
                        </tr>   

                        <?php
                    }

                } else 
                {
                    // We do not have data
                    // we will display te messega inside table
                    ?>
                        <tr>
                            <td colspan="6"><div class="error">No Category Added</div></td>
                        </tr>
                    <?php
                }
            
            
            ?>

            
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
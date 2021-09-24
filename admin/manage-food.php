<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br /><br />

        <!-- Button to Add Food -->

        <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>

        <br /><br /><br />

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
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
            if(isset($_SESSION['unauthorized']))
            {
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                //Create Sql Query to get all the food
                $sql = "SELECT * FROM tbl_food";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count Rows tk check whether we have foods or not
                $count=mysqli_num_rows($res);

                // Create number variable and set default value as 1
                $sn = 1;


                if($count > 0){
                    //We have food in database
                    // Get the foods from database and display
                    while($row=mysqli_fetch_assoc($res)){
                        // Get the value from individuals colums
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                        <tr>
                            <td><?=$sn++?>.</td>
                            <td><?=$title?></td>
                            <td>$<?=$price?></td>
                            <td>
                                <?php
                                    //Check whether we have image or not
                                    if($image_name==""){
                                        //We do nat have image, display error message
                                        echo "<div class='error'>Image Not Added</div>";
                                    } else {
                                        //we have image, display image
                                        ?>
                                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name?>" width="100px">
                                        <?php

                                    }
                                ?>
                            </td>
                            <td><?=$featured?></td>
                            <td><?=$active?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?=$id?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?=$id;?>&image_name=<?=$image_name;?>" class="btn-danger">Delete Food</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    //Food not addedd to database
                    echo "<tr><td colspan='7' class='error'>Food not Added Yet</td></tr>";
                }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
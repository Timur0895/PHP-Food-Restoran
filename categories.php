<?php include('partials-front/menu.php'); ?>


    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            
            //Display all the categories that area active
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
            //Execute the query
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if($count > 0){
                //Availible
                while($row = mysqli_fetch_assoc($res)){
                    //Get the values like title image name and id
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                            <a href="<?php echo SITEURL?>category-foods.php?category_id=<?=$id?>">
                                <div class="box-3 float-container">
                                    <?php
                                    //Check whether image availible or not
                                        if($image_name ==""){
                                            //Display the message
                                            echo "<div class='error'>Image not Found</div>";
                                        } else {
                                            // Image availible
                                            ?>
                                            <img src="<?php echo SITEURL?>images/category/<?=$image_name?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="float-text text-white"><?=$title;?></h3>
                                </div>
                            </a>
                        <?php
                }
            } else {
                // NOt availible
                echo "<div class='error'>Categories Not Found</div>";
            }

            ?>          

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->
<?php include('partials-front/footer.php'); ?>
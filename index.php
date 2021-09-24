<?php include('partials-front/menu.php'); ?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>


    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                // Creaye Sql query to display catigories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured ='Yes' LIMIT 3";
                //Execute the query
                $res = mysqli_query($conn, $sql);
                //Countthe row to check whether the category is availible or not
                $count =  mysqli_num_rows($res);

                if($count > 0){
                    // Availeble
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
                                            echo "<div class='error'>Image not Availible</div>";
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
                    //Categoru not availble
                    echo "<div class='error'>Categories Not Added</div>";
                }

            
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //getting food from database that are active and featured
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured = 'Yes' LIMIT 6";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                $count2 = mysqli_num_rows($res2);

                //check whether food availible or not
                if($count2 > 0){
                    //Availible
                    while($row2 = mysqli_fetch_assoc($res2)){
                        // Get all the values
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $desc = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php
                                        // Check whether image availible or not
                                        if($image_name ==""){
                                            //Display the message
                                            echo "<div class='error'>Image not Availible</div>";
                                        } else {
                                            // Image availible
                                            ?>
                                            <img src="<?php echo SITEURL?>images/food/<?=$image_name?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?=$title?></h4>
                                    <p class="food-price">$<?=$price?></p>
                                    <p class="food-detail">
                                        <?=$desc;?>
                                    </p>
                                    <br>

                                    <a href="<?php SITEURL;?>order.php?food_id=<?=$id?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                        <?php

                    }
                } else {
                    //NOt availible
                    echo "<div class='error'>Food Not Availible</div>";
                }
            ?>

                        <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
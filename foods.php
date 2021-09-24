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



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //getting food from database that are active and featured
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                //check whether food availible or not
                if($count > 0){
                    //Availible
                    while($row = mysqli_fetch_assoc($res)){
                        // Get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $desc = $row['description'];
                        $image_name = $row['image_name'];
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

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                //get the search keyword
                //$search = $_POST['search'];
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            <h2>Foods on Your Search <a href="#" class="text-white">"<?=$search;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                
                // Sql query to get foods based on search keyword
                //$search = burger '; DROP database name;
                //"SELECT * FROM tbl_food WHERE title LIKE '%burger'%' OR description '%burger'%'";
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                // EXEcute the query
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                // check wheterh food availible or not
                if($count>0)
                {
                    //availible
                    while($row = mysqli_fetch_assoc($res))
                    {
                        //get the detail
                        $id = $row['id'];
                        $title = $row['title'];
                        $price= $row['price'];
                        $desc = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                            <?php
                                    //Check whether image availible or not
                                        if($image_name ==""){
                                            //Display the message
                                            echo "<div class='error'>Image not Found</div>";
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
                                    <?=$desc?>
                                </p>
                                <br>

                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    //Food not availible
                    echo "<div class='error'>Food Not Found</div>";
                }
            ?>

            
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
<?php ob_start();
include('partials-front/menu.php');
?>

<?php
    // check whetehr id passed or not
    if(isset($_GET['category_id']))
    {
        // Category id is set and get the id
        $category_id = $_GET['category_id'];

        //get the category titli bassed on category id
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        $res = mysqli_query($conn, $sql);

        // Get the value from database
        $row = mysqli_fetch_assoc($res);

        //get the title
        $category_title = $row['title'];
    } else {
        // Category not passed we redirect to home page
        header("location:".SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?=$category_title?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // Sql query to get foods bassed oon selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                $count = mysqli_num_rows($res2);

                // check whether food is availible or not
                if($count>0)
                {
                    //Availible
                    while($row2 = mysqli_fetch_assoc($res2)) {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $desc = $row2['description'];
                        $image_name = $row2['image_name'];
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

                                    <a href="<?php SITEURL;?>order.php?food_id=<?=$id?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php

                    }

                } else {
                    //Not availible
                    echo "<div class='error'>Food Not Availeble</div>";
                }


            ?>

            <div class="clearfix"></div>
            
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
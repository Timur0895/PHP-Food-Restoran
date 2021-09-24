<?php include('partials-front/menu.php'); ?>

<?php
    // check wheter food id set or not
    if(isset($_GET['food_id'])){
        //get the food id
        $food_id = $_GET['food_id'];

        //getthedeatails of seleced fodd
        $sql="SELECT * FROM tbl_food WHERE id= $food_id";
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);
        // check whette the data is availible or not
        if($count==1){
            // we have data
            // get the data from databse
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];

        } else {
            // food not availible
            //redirect to home
            header("location:".SITEURL);
        }

    } else {
        //Redirect to home page
        header("location:".SITEURL);
    }


?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?=$title?></h3>
                        <input type="hidden" name="food" value="<?=$title?>">
                        <p class="food-price">$<?=$price?></p>
                        <input type="hidden" name="price" value="<?=$price?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                // check whether submit button clickeed or not
                if(isset($_POST['submit'])){
                    // Get all the details from form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty; // total = price * qty
                    $order_date = date("Y-m-d h:i:s");
                    $status = "Ordered";// ordered, on delivary, delivered, canceled
                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];


                    // Save order in database
                    //create sql to save data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";
                    //echo $sql2; die();
                    $res2 = mysqli_query($conn, $sql2);

                    //var_dump($conn); die();

                    // check whetre query executed or not
                    if($res2==true){
                        // Query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfflly</div>";
                        header("location:".SITEURL);
                    } else {
                        //Failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food</div>";
                        header("location:".SITEURL);
                    }
                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
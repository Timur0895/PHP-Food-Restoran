<?php include('partials/menu.php');
?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>
                <br><br>
                <?php
                    if(isset($_SESSION['login'])) {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>
                <br><br>

                <div class="col-4 text-center">
                    <?php
                        //Sql Query
                        $sql = "SELECT * FROM tbl_category";
                        //Execute Query
                        $res = mysqli_query($conn, $sql);

                        //conut rows
                        $count = mysqli_num_rows($res);
                    
                    ?>
                    <h1><?=$count?></h1>
                    <br>
                    Categories
                </div>
                <div class="col-4 text-center">
                    <?php
                        //Sql Query
                        $sql2 = "SELECT * FROM tbl_food";
                        //Execute Query
                        $res2 = mysqli_query($conn, $sql2);

                        //conut rows
                        $count2 = mysqli_num_rows($res2);
                    
                    ?>
                    <h1><?=$count2?></h1>
                    <br>
                    Foods
                </div>
                <div class="col-4 text-center">
                    <?php
                        //Sql Query
                        $sql3 = "SELECT * FROM tbl_order";
                        //Execute Query
                        $res3 = mysqli_query($conn, $sql3);

                        //conut rows
                        $count3 = mysqli_num_rows($res3);
                    
                    ?>
                    <h1><?=$count3?></h1>
                    <br>
                    Total Orders
                </div>
                <div class="col-4 text-center">

                    <?php
                        // create Sql query to get total Revenue Genereated
                        //Aggregate Function in SQL
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                        //Execute the Query
                        $res4 = mysqli_query($conn, $sql4);

                        //get the value
                        $row4 = mysqli_fetch_assoc($res4);

                        //get the Total Revenue
                        $total_revenue = $row4['Total'];
                    
                    ?>
                    <h1>$ <?=$total_revenue;?></h1>
                    <br>
                    Revenue Generated
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
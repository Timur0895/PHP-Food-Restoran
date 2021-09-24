<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S. N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            
            // get all the orders from databese
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1; // create a serail number and set 1

            if($count>0) {
                // Order availible
                while($row = mysqli_fetch_assoc($res))
                {
                    // get all the orders details
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

                    ?>

                        <tr>
                            <td><?=$sn++;?></td>
                            <td><?=$food?></td>
                            <td><?=$price?></td>
                            <td><?=$qty?></td>
                            <td><?=$total?></td>
                            <td><?=$order_date?></td>

                            <td>
                                <?php
                                    // Ordered ON delivery, Delivered, Cancelled
                                    if($status=="Ordered")
                                    {
                                        echo "<label>$status</label>";
                                    } elseif($status=="On Delivery")
                                    {
                                        echo "<label style='color: orange;'>$status</label>";
                                    } elseif($status=="Delivered")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    } elseif($status=="Cancelled")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }
                                ?>
                            </td>

                            <td><?=$customer_name?></td>
                            <td><?=$customer_contact?></td>
                            <td><?=$customer_email?></td>
                            <td><?=$customer_address?></td>
                            <td>
                                <a href="<?php echo SITEURL?>admin/update-order.php?id=<?=$id?>" class="btn-secondary">Update Order</a>
                            </td>
                        </tr>

                    <?php



                }
            } else {
                //Order mot availible
                echo "<tr><td colspan='12 class='error'>Orders not Availible</td></tr>";
            }
            
            ?>

            

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
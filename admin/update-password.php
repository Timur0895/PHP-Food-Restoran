<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
            }
        
        ?>


        <form action="" method="POST">
        
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>                
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary" >
                    </td>
                </tr>

            </table>
        
        </form>
    </div>
</div>


<?php
    //Check whether the Sumbit Button is Clicked or not
    if(isset($_POST['submit'])) {
        //echo "Clicked";
        // 1. Get the data from Form

        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // 2. Check whether the user with current Id and Current PAssword Exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        if($res == true) {
            //Check whether data is availible or not
            $count = mysqli_num_rows($res);

            if($count == 1) {
                // User exicts and password can be Chenge
                //echo "user Found";

                // Check whether the new password adn Confirm match or not
                if($new_password==$confirm_password) {
                    //Update the Password
                    //echo "Password Match";

                    $sql2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id = $id";

                    // Execute Query
                    $res2 = mysqli_query($conn, $sql2);

                    //Check whetheer the Query executed or not
                    if($res2==true) {
                        // Display Success Message
                        // Redirect to Manage Page with Success Message
                        $_SESSION['change-pwd'] = "<div class='success'>Password Change Successfully</div>";
                        // Redirct the User
                        header("location:".SITEURL.'admin/manage-admin.php');

                    } else {
                        //Display Error Message
                        // Redirect to Manage Page with Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Password Not Changed</div>";
                        // Redirct the User
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }


                } else {
                    // Redirect to Manage Page with Error Message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Not Match</div>";
                    // Redirct the User
                    header("location:".SITEURL.'admin/manage-admin.php');
                }

            } else {
                // User does not Exists set Message and Redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                // Redirct the User
                header("location:".SITEURL.'admin/manage-admin.php');

            }

        }


        // 3. Check whether the New Password and Confirm Password Match or not

        // 4. Update Password if all above true


    }



?>

<?php include('partials/footer.php') ?>
<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
            // 1. Get the id of selected admin
            $id=$_GET['id'];    
            // 2. Create Sql Query to Get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";
            // 3. Execute Query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if($res == true) {
                // Chck whether tha data is availible or not
                $count = mysqli_num_rows($res);
                // Chech whether we have admin data or not
                if($count == 1) {
                    //Get details
                    //echo "Admin Availible";
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    // Redirect to MAnage ADmin Page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Fullname</td>
                    <td>
                        <input type="text" name="full_name" value="<?=$full_name?>">
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?=$username?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?=$id?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php

    // CHeck Whether the submit buton is Clicked or not
    if(isset($_POST['submit'])) {
        //echo "Button clicked";
        // get all the values from Form to Update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username']; 

        // Create Sql Query to update Admin
        $sql = "UPDATE tbl_admin SET full_name = '$full_name', username = '$username' WHERE id=$id";
        // Execute Query
        $res = mysqli_query($conn, $sql);


        // Check whether the query executed successfully or not
        if($res == true) {
            //Query executed and Admin updated
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
            // Redirect to manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        } else {
            // Failed to Update Admin
            $_SESSION['update'] = "<div class='error'>Admin Update Failed</div>";
            // Redirect to manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }    

?>

<?php include('partials/footer.php'); ?>
<?php include('partials/menu.php') ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br />

        <?php
        if (isset($_SESSION['add'])) // Checking whether the session is set or not
        {
            echo $_SESSION['add']; 
            unset($_SESSION['add']); 
        };
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>


    </div>
</div>


<?php include('partials/footer.php'); ?>
<?php
//Process the value from Form and Save it in Database
//Check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    // Button clicked
    //1. Get the data from our Form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Password Encryption with md5

    //2. SQL Query to Save the data into Database

    $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

    // 3. Executing Query and Saving data into Database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
    if ($res == true) {
        // Data Ok
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
        // Redirect Page to manage Admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // Data False
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
        // Redirect Page to manage Admin
        header("location:" . SITEURL . 'admin/add-admin.php');
    };
}
?>
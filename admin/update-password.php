<?php
    include('partials/menu.php')
?>

<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
    <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        
    ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="Current Password"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="new_password" placeholder="New Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
            } else {
                // user did not specify an ID, redirect to page where they can select one
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        ?>
    </div>
</div>
<!-- UPDATE PASSWORD FORM PROCESSING SECTION -->
<?php
    // check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //1. get data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']); 

        //2. check whether user with current ID and current password exists
        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
        $result = mysqli_query($conn, $sql);

        if($result)
        {
            //Check whether data is available or not
            $count = mysqli_num_rows($result);
            if($count == 1)
            {
                //user exists and password can be changed
                //3. check whether new password and confirm password match or not
                if ($new_password === $confirm_password)
                {
                    //4. change password if all above is true
                    $sql = "UPDATE tbl_admin SET 
                        password='$new_password' 
                        WHERE id=$id
                    ";
                    $result = mysqli_query($conn, $sql);

                    //check whether the query is executed successfully or not
                    if($result)
                    {
                        //password changed successfully
                        $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully</div>";
                        //redirect user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //failed to change password
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change password</div>";
                        //redirect user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //new password and confirm password do not match
                    $_SESSION['pwd-not-match'] = "<div class='error'>New password and confirm password do not match</div>";
                    //redirect user to manage-admin.php page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //user does not exist, set message and redirect
                $_SESSION['user-not-found'] = "<div class='error'>User not found</div>";
                //redirect user to manage-admin.php page
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        else
        {
            //query execution failed
            echo "Failed to execute query.";
        }
    }
?>








<!-- UPDATE PASSWORD FORM PROCESSING SECTION -->
<?php
    // check whether submit button is clicked or not
    // if(isset($_POST['submit']))
    // {
    //     // echo "clicked";
    //     //1. get data from form
    //     $id = $_POST['id'];
    //     $current_password = md5($_POST['current_password']);
    //     $new_password = md5($_POST['new_password']);
    //     $confirm_password = md5($_POST['confirm_password']); 
    //     //2. check whether user with current ID and current passsword exists-create an sql query
    //     $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
    //     //2b. execute sql query
    //     $result = mysqli_query($conn, $sql);
    //     if($result == TRUE)
    //     {
    //         //Check whether data is available or not
    //         $count = mysqli_num_rows($result);
    //         if($count == 1)
    //         {
    //             //user exists and password can be changed
    //             echo "user found";
                
    //         }
    //         else
    //         {
    //             //user does not exist, set message and redirect
    //             $_SESSION['user-not-found'] = "<div class='error'>User not found</div>";
    //             //redirect user
    //             header('location:'.SITEURL.'admin/manage-admin.php');
    //         }
    //     }
        
    //     //3. check whether new password and confirm password match or not
    //     //4. change password if all above is true
    // }
?>
<!-- Main content section ends -->

<?php
    include('partials/footer.php')
?>
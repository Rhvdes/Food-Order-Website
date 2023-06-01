<?php
    include('partials/menu.php');
?>
<!-- Main Content Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>
        <?php
            //1.get the id of selected admin
            $id = $_GET['id'];
            //2. create sql query
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";
            //3. Execute the query
            $result = mysqli_query($conn, $sql);
            //4. check whether query executed successfully or not
            if($result == TRUE)
            {
                //check whether data is available or not
                $count = mysqli_num_rows($result);
                //check whether we have admin data or not
                if($count == 1)
                {
                    //Get the details
                    // echo "Admin Available";
                    //display the data from the database
                    $row = mysqli_fetch_assoc($result);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {
                    //redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name;?>"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php echo $username?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <!-- to get the value of the data -->
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>
<!-- UPDATE ADMIN PROCESSING SECTION -->
<?php
    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // echo "Button clicked";
        //Get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //create sql query to update admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";
        //Execute the query
        $result = mysqli_query($conn, $sql);

        //check whether query executed or not
        if($result == TRUE)
        {
            //query executed and admin updated
            //Create a session variable
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
            //Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to update admin
             //Create a session variable
             $_SESSION['update'] = "<div class='error'>Failed to Update Admin</div>";
             //Redirect to Manage Admin Page
             header('location:'.SITEURL.'admin/manage-admin.php');
        }

    }
?>
<!-- Main Content Ends -->


<?php
    include('partials/footer.php');
?>
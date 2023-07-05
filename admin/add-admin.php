<?php
include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
            if(isset($_SESSION['add']))//checking whether session is set or not
            {
                echo $_SESSION['add'];//display session message if set
                unset($_SESSION['add']);//remove the session message
            }
        ?>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Your username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="not less than 6 digits"></td>
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

<?php
include('partials/footer.php');
?>
<?php
//process value from form and save it in database

 //check whether the submit button is clicked or not
 if(isset($_POST['submit']))
 {
     //button clicked
     // echo "Button clicked";
    
    
     //1.Get data from form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password'])); //password encrypted with md5
    
    
    //2.SQL Query to save data into database
    $sql = "INSERT INTO tbl_admin SET
    full_name = '$full_name',
    username = '$username',
    password = '$password'
    ";
    
    //3. Execute query and saving data into database
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    //4. check whether the query is executed and inserted or not and display appropriate error message
    if($result == TRUE)
    {
        //data inserted
        // echo "data inserted";
        //creating a session variable to display message
        $_SESSION['add'] = "<div class='success'>Admin added successfully</div>";
//     //redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to insert data
        // echo "failed to insert data";
        //creating a session variable to display message
        $_SESSION['add'] = "<div class='error'>Failed to add Admin</div>";
//     //Redirect page to Add Admin
        header("location:".SITEURL.'admin/add-admin.php');
    }
 }
?>
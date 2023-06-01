<?php
    if(isset($_GET['id'])) {
        // get the id of the admin to be deleted
        $id = $_GET['id'];
      
        // rest of the code
      } else {
        echo "ID parameter is missing";
      }
      
//include constants file cause of the $conn variable
    include('../config/constants.php');
    //1. get the id of the admin to be deleted
    $id = $_GET['id'];

    //2. create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id = $id";
    //3. execute the query
    $result = mysqli_query($conn, $sql);
    //4. check whether query executed successfully or not
    if($result == TRUE)
    {
        //query executed successfully
        // echo "Admin deleted successfully";
        //create session variable to display success message
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully</div>";
        //Redirect to  Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to delete admin
        // echo "failed to delete admin";
        //Create a session variable to display failed message
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin, Try again later</div>";
        //redirect to Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    //5. redirect to manage admin page with a message either successful or not
?>
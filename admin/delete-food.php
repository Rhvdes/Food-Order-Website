<?php 
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //permission to delete
        //1. get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        //2. remove image if available
        //2a. check whether image is available or not and delete if available
        if($image_name !="")
        {
            //image is available delete
            //get image path
            $path = "../images/food/".$image_name;
            //remove image file from folder
            $remove = unlink($path);
            //check whether image is removed or not
            if($remove==false)
            {
                //failed to remove
                $_SESSION['remove'] = "<div class='error'>Failed to remove Image</div>";
                //redirect
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process
                die();
            }
        }
        //3. delete food data from database
        //3a. create SQL query
        $sql = "DELETE FROM tbl_food WHERE id = $id";
        //3b. execute the query
        $result = mysqli_query($conn, $sql);
        //3c. check whether query is executed successfully or not
        if($result == TRUE)
        {
            //Food data deleted successfully
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            //redirect
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete food data from database
            $_SESSION['delete'] = "<div class='error'>Food Data not Deleted</div>";
            //redirect
            header('location:'.SITEURL.'admin/manage-food.php');
            //stop the process
            die();
        }
    }
    else
    {
        //redirect to manage food page and display error message
        $_SESSION['access-denied'] = "<div class='error'>Acccess Denied</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
        
    }
?>
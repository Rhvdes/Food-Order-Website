<?php
    //include constant file
    include('../config/constants.php');
    
    //check whether the id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the data value and delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the image file only if available then delete from database and redirect
        if($image_name!="")
        {
            //image is available, remove image to do that we create a variable for the image path
            $path = "../images/category/".$image_name;
            //remove image
            $remove = unlink($path);
            
            //if failed to remove image, display an error and stop the process
            if($remove==false)
            {
                //set session message
                $_SESSION['remove'] = "<div class='error'>Failed to remove Image</div>";
                //redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }

        }
        //delete data from database
        //sql query to delete data from the database
        $sql = "DELETE FROM tbl_category WHERE id=$id";
        //execute query
        $result = mysqli_query($conn, $sql);
        //check whether data is deleted from database or not
        if($result==true)
        {
            //set success message
            $_SESSION['delete'] = "<div class='sucess'>Category Deleted Successfully</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //set failed message
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
        }



    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>
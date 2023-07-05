<?php
    include('partials/menu.php');
?>
<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get the details
        $id = $_GET['id'];

        //create sql query to get id of selected foods
        $sql2 = "SELECT * FROM tbl_food where id=$id";
        //execute the query
        $result2 = mysqli_query($conn, $sql2);
        //get the value based on executed query
        $row2 = mysqli_fetch_assoc($result2);
        //above would give results in array form
        
        //to get individual values of selected foods
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //not set redirect
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>
<!-- Main Content Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
               <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title;?>">
                </td>
               </tr>
               <tr>
                <td>Description:</td>
                <td><textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea></td>
               </tr>
               <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price;?>">
                </td>
               </tr>
               <tr>
                <td>Current Image:</td>
                <td>
                    <?php
                        if($current_image == "")
                        {
                            //image not available
                            echo "<div class='error'>Image not Available</div>";
                        }
                        else
                        {
                            //image available
                            ?>
                            <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" alt="<?php echo $title;?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
               </tr>
               <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
               </tr>
               <tr>
    <td>Category:</td>
    <td>
        <select name="category">
            <?php
            // Create SQL query to get all active categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
            // Execute query
            $result = mysqli_query($conn, $sql);
            // Count rows
            $count = mysqli_num_rows($result);
            
            // Check whether categories are available or not
            if ($count > 0) 
            {
                // Categories are present
                // Use a while loop to display categories
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $category_title = $row['title'];
                    $category_id = $row['id'];
                    if ($category_id == $current_category) 
                    {
                        // If the current category matches the food's category, mark it as selected
                        echo "<option value='$category_id' selected>$category_title</option>";
                    } 
                    else 
                    {
                        echo "<option value='$category_id'>$category_title</option>";
                    }
                }
            } 
            else 
            {
                // Category not available
                echo "<option value='0'>Category not Available</option>";
            }
            ?>
        </select>
    </td>
</tr>

               <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                </td>
               </tr>
               <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "checked";}?>  type="radio" name="active" value="No">No
                </td>
               </tr>
               <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
               </tr>
            </table>
        </form>

        <?php 
            //check if buttton is clicked or not
            if(isset($_POST['submit']))
            {
                //button clicked
                //1. get all details from form
                $id = $_POST['id'];
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];
                //2. upload image if selected
                //2a. check whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    $image_name = $_FILES['image']['name'];//New image name
                    //check whether file is available or not
                    if($image_name !="")
                    {
                        //A. image is available
                        //rename image
                        $ext = end(explode('.', $image_name));//gets image extension
                    
                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;//image will be renamed

                        //get source path and destination path
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/food/".$image_name;

                        //upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        if($upload == false)
                        {
                            //failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to upload new Image</div>";
                            //redirect to manage-food page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
                        }
                        //3. remove image if new image is uploaded and current image exists
                        //B. Remove current image if available
                        if($current_image != "")
                        {
                            //current image is present
                            //remove the image
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            //check whether image is removed or not
                            if($remove == false)
                            {
                                //failed to remove current image
                                $_SESSION['remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                //redirect to manage-food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;//default image when image is not selected
                    }
                }
                else
                {
                    $image_name = $current_image;//default image when upload button is not clicked
                }
                //4. update food in database
                //create sql query
                $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id = $id
                ";
                //execute query
                $result3= mysqli_query($conn, $sql3);
                //check whether query is executed or not
                if($result3==TRUE)
                {
                    //query executed database updated
                    $_SESSION['updated'] = "<div class='success'>Food Updated Successfully</div>";
                    //redirect to manage-food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to execute
                    $_SESSION['updated'] = "<div class='error'>Failed to Updated Food</div>";
                    //redirect to manage-food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }
        ?>
        </div>
</div>
<?php
    include('partials/footer.php');
?>
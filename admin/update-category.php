<?php
    include('partials/menu.php')
?>
<!-- Main-content starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>
            <br><br>

            <?php
                //check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //get the id
                    $id = $_GET['id'];
                    //create sql query to get other details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";

                    //execute query
                    $result = mysqli_query($conn, $sql);

                    //count the number of rows to check if id is valid
                    $count = mysqli_num_rows($result);

                    if($count==true)
                    {
                        //get all data
                        $row = mysqli_fetch_assoc($result);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                    }
                    else
                    {
                        //redirect to manage-category page
                        $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
                else
                {
                    //redirect to manage-category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td><?php 
                        if($current_image !="")
                        {
                            //display image
                            ?>
                            <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px">
                            <?php
                        }
                        else
                        {
                            //display message
                            echo "<div class='error'>Image not Added.</div>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?>  type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    
                    <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {
                //1 Get all value from form
                $id = $_POST['id'];
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2 Updating new image if selected
                //check if image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];
                    //check whether image is available or not
                    if($image_name != "")
                    {
                        //image is available
                        //A.Upload the new image
                         //Auto rename image
                        //get extension of image i.e jpg, jpeg etc.
                        $extension = end(explode('.', $image_name));
                        //rename image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$extension;
                        
                        $source_path = $_FILES['image']['tmp_name'];
                        
                        $destination_path = "../images/category/".$image_name;

                        //finally upload image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether image is uploaded or  not
                        //and iff not uploaded give error and redirect
                        if($upload == FALSE)
                        {
                            //set error message
                            $_SESSION['upload'] = "<div class = 'error'>Failed to Upload Image</div>";
                            //redirect to add-category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                        //B.Remove current image if available
                        if($current_image !="")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //check whether image is removed or not
                            //if failed to remove image display error message and stop the process
                            if($remove==false)
                            {
                                //failed to remove image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                //redirect
                                header('location:'.SITEURL.'admin/manage-category.php');
                                //stop the process
                                die();

                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
                //3 Update database
                $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id = $id
                ";
                //execute sql query
                $result2 = mysqli_query($conn, $sql2);
                //4 Redirect to manage category page
                //check whether query executed or not
                if($result2==TRUE)
                {
                    //category added successfully
                    $_SESSION['update'] = "<div class='success'>Category Updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Updated Category</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }
        ?>
        </div>
    </div>
<!-- Main-content ends -->

<?php
    include('partials/footer.php')
?>
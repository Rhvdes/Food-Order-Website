<?php
    include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrappper">
        <h1>Add Food</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Food Title">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" id="" cols="30" rows="5" placeholder="food description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            
                        <?php
                            //to display categories from database
                            //1. Create SQL query to get all active category from Database
                            $sql= "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute the query
                            $result= mysqli_query($conn, $sql);
                            //count rows to check if categories is present or not
                            $count = mysqli_num_rows($result);
                            if($count > 0)
                            {
                                //categories is present
                                //use while loop to display the values 
                                while($row=mysqli_fetch_assoc($result))
                                {
                                    //get details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id;?>"><?php echo $title;?></option>
                                    <?php

                                }
                            }
                            else
                            {
                                //no category 
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                        ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No 
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add food Form ENDS -->
        <?php
            //check whether button is clicked or not
            if(isset($_POST['submit']))
            {
                //add food in database
                
                //1. get data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                //1a.need to check if button for featured and active are clicked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    //default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    //default value
                    $active = "No";
                }
                //2. upload image if selected
                //2a. check whether select image BUTTON is clicked or not and upload only if image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected or not and only upload if selected
                    if($image_name !="")
                    {
                        //image is selected
                        //A. rename the image
                        //(i).get the extension of selected image which can be either of these(jpg, png, gif etc.)
                        $ext = end(explode('.', $image_name));
                        //(ii). create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;
                        // $image_name = "Food-Name-".rand(0000,9999).str_replace('food', '', strtolower($image_name));


                        //B. upload the image
                        //(i). get the source path and destination path
                        //source path is the current location of the image
                        $source_path = $_FILES['image']['tmp_name'];
                        //destination path for the image to be uploaded
                        $destination_path = "../images/food/".$image_name;

                        //(ii).finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
                        //(iii). check whether image is uploadedor not
                        if($upload==false)
                        {
                            //failed to upload,display error message and redirect then stop the process
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }
                    }

                }
                else
                {
                    //default value if not clicked
                    $image_name = "";
                }
                //3. insert into database
                //(i). create sql query to add food data to database
                $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";
                //(ii).execute the query
                $result2 = mysqli_query($conn, $sql2);
                //(iii) check whether data is inserted or not and redirect
                if($result2 == TRUE)
                {
                    //Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
        ?>
    </div>

</div>
<?php
    include('partials/footer.php');
?>
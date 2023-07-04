<?php
    include('partials/menu.php')
?>
<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br> <br>

        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br> <br>
        <!-- Add Category Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category title"></td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <!-- Add Category Form End -->
        <?php
            //check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // echo "clicked";

                //1. Get the value from category form
                $title = $_POST['title'];

                //for Radio input type, check whether button is selected or not
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                    //get the value from form
                    $active = $_POST['active'];
                }
                else
                {
                    //set the default value
                    $active = "No";
                }
                //check whether image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);//used print_r instead of echo because echo doesnt display value of array
                
                //die(); //break the code here

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //to upload image, we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload image only when selected
                    if($image_name != "")
                    {
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
                    }
                }
                else
                {
                    //don't upload image and set image_name value as blank
                    $image_name = "";
                }
                //2. create SQL query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";
                //3. execute query and save data in database
                $result = mysqli_query($conn, $sql);
                //4 check whether query executed or not to know if data was added or not
                if($result == TRUE)
                {
                    //query executed successfully, category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        ?>
    </div>
</div>
<!-- Main content section ends -->
<?php
    include('partials/footer.php')
?>
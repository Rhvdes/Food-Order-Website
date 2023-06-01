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
                            //create sql query to get all active category
                            $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute query
                            $result = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($result);
                            
                            //check whether category is available or not
                            if($count>0)
                            {
                                //category is present
                                //use while loop to display categories
                                while($row=mysqli_fetch_assoc($result))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    echo "<option value='$category_id'>$category_title</option>";
                                }
                            }
                            else
                            {
                                //category not available
                                // echo "<option value='0'>Category not Available</option>";
                                ?>
                                <option value="<?php echo $category_id;?>"><?php echo $category_title;?></option>
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
                <td><input type="submit" name="submit" value="Update Food" class="btn-secondary"></td>
               </tr>
            </table>
        </form>
        </div>
</div>
<?php
    include('partials/footer.php');
?>
<?php
include('partials/menu.php');
?>
<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br> <br>
            <!-- button to add Food -->
            <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">Add Food</a>
            <br><br><br>
            <?php
                if(isset($_SESSION['add']))
                {
                   echo $_SESSION['add'];
                   unset($_SESSION['add']); 
                }
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['access-denied']))
                {
                    echo $_SESSION['access-denied'];
                    unset($_SESSION['access-denied']);
                }
                if(isset($_SESSION['remove']))
                {
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                }
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
                if(isset($_SESSION['updated']))
                {
                    echo $_SESSION['updated'];
                    unset($_SESSION['updated']);
                }
            ?>
            <table>
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php 
                    //create sql query to get all the food data
                    $sql = "SELECT * FROM tbl_food";
                    //execute the query
                    $result = mysqli_query($conn, $sql);
                    //count ros to check if food data is present or not

                    //note for serial number below it's outside of the while loop to be able to set the number to default as 1 and keeps increasing based on the data provided.
                    $sn=1;
                    $count = mysqli_num_rows($result);
                    if($count>0)
                    {
                        //food data is present in database
                        //get food data from database using While loop
                        while($row=mysqli_fetch_assoc($result))
                        {
                            //get individual data
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                            ?>
                               <tr>
                                    <td><?php echo $sn++;?></td>
                                    <td><?php echo $title;?></td>
                                    <td>&#8358;<?php echo $price;?></td>
                                    <td><?php 
                                    //check whether image is available or not?
                                    if($image_name=="")
                                    {
                                        //we do not have image, display error message
                                        echo "<div class='error'>Image not Added</div>";
                                    }
                                    else
                                    {
                                        //image is available, display image
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" width="100px">
                                        <?php
                                    }
                                    ?>
                                    </td>
                                    <td><?php echo $featured;?></td>
                                    <td><?php echo $active;?></td>
                                    <td><a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
                                    <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Food</a>
 <!-- the link for this delete page had to include id and image name in order for the data to be deleted from the database and id and image_name were already declared above(made use of GET method cause value would be passed through URL) -->
                                    </td>
                                </tr>
                            <?php
                            //after getting individual data only after this is done(as shown above) before you can be able to display the value in the form as seen below
                        }
                    }
                    else
                    {
                        //food data not present in database
                        echo "<tr><td colspan='7' class='error'>Food not Added yet</td></tr>";
                    }
                ?>
            </table>
    </div>
  </div>
<!-- Main content section ends -->
<?php
include('partials/footer.php');
?>
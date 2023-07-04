<?php
    include('partials-front/menu.php');
?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //display all categories that are active in database
                //create sql query
                $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                //execute the query
                $result = mysqli_query($conn, $sql);
                //count rows
                $count = mysqli_num_rows($result);
                //check whether categories is available or not
                if($count>0)
                {
                    //category is present
                    //use while loop to fetch data from database
                    while($row=mysqli_fetch_assoc($result))
                    {
                        //get the values
                        $id=$row['id'];
                        $title=$row['title'];
                        $image_name=$row['image_name'];
                        ?>
                         <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                    //check if image name is available or empty
                                    if($image_name=="")
                                    {
                                        //image is not available
                                        echo "<div class='error'>Image not Found</div>";
                                    }
                                    else
                                    {
                                        //image is available
                                        ?>
                                          <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                              

                                <h3 class="float-text text-white"><?php echo $title;?></h3>
                            </div>
                    </a>
                        <?php
                    }
                }
                else
                {
                    //category is not present
                    echo "<div class='error'>Category not Found</div>";
                }
            ?>
           
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->
<?php 
        include('partials-front/footer.php');
?>


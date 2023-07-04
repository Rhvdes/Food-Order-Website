<?php
    include('partials-front/menu.php');
?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        if(isset($_SESSION['contact']))
        {
            echo $_SESSION['contact'];
            unset($_SESSION['contact']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <di class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //create sql query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //execute the query
                $result = mysqli_query($conn, $sql);
                //count rows to ceck if category is available or not
                $count = mysqli_num_rows($result);
                if($count>0)
                {
                    //categories are present
                    //a. use while loop to display available categories
                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                if ($image_name == "") 
                                {
                                    echo "<div class='error'>Image is not Available</div>";
                                } else 
                                {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>"
                                         alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                        <?php
                    }
                    
                        ?>   
                        <?php
                    }
                else
                {
                    //not present
                    echo "<div class='error'>Categories not Present</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //display food from database that are active and featured
                //create sql query
                $sql2= "SELECT * FROM tbl_food WHERE featured='Yes' AND active='Yes' LIMIT 6";
                //execute the query
                $result2=mysqli_query($conn, $sql2);
                //count the rows
                $count2=mysqli_num_rows($result2);
                //check whether food data is present or not
                if($count2>0)
                {
                    //food is present
                    //use while loop to display food data
                    while($row=mysqli_fetch_assoc($result2))
                    {
                        //get all the data
                        $id=$row['id'];
                        $title=$row['title'];
                        $description=$row['description'];
                        $price=$row['price'];
                        $image_name=$row['image_name'];
                        ?>
                          <div class="food-menu-box">
                            <div class="food-menu-img">
                            <?php
                                //check whether image is available or not
                                if($image_name=="")
                                {
                                    //image is not present
                                    echo "<div class='error'>Image is not Available</div>";
                                }
                                else
                                {
                                    //image is present
                                    ?>
                                    <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">&#8358;<?php echo $price;?></p>
                                <p class="food-detail"><?php echo $description;?></p>
                                <br>

                                <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    //food is not present
                    echo "<div class='error'>Food is not Available</div>";
                }
            ?>
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->
<?php
    include('partials-front/footer.php');
?>
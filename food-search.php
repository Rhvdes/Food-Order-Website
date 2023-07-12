<?php
include('partials-front/menu.php');
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        // Check if the search key is set in $_POST array
        if (isset($_POST['search'])) 
        {
            //get the search keywords
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            <h2>Foods on Your Search <a href="#" class="text-white"><?php echo $search; ?></a></h2>
            <?php
            //create sql query to get food based on search keyword
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            //execute the query
            $result = mysqli_query($conn, $sql);
            //count rows
            $count = mysqli_num_rows($result);
            //check whether food is available or not
            if ($count > 0) 
            {
                //food is available
                //use while loop to display all available food
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            //check if image is available or not
                            if ($image_name == "") 
                            {
                                //image is not available
                                echo "<div class='error'>Image not Found</div>";
                            } 
                            else 
                            {
                                //image is available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"
                                     alt="" class="img-responsive img-curve">
                                <?php
                            }
                            ?>

                        </div>
                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">&#8358;<?php echo $price; ?></p>
                            <p class="food-detail"><?php echo $description; ?></p>
                            <br>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                    <?php
                }
            } 
            else 
            {
                //food is not available
                echo "<div class='error'>Food is not Available</div>";
            }
        } 
        else 
        {
            // Search key is not set in $_POST array
            echo "<h2 class='text-white'>Please perform a search first.</h2>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php
include('partials-front/footer.php');
?>

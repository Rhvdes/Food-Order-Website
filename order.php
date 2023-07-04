<?php 
        include('partials-front/menu.php');
?>
    <?php
        //check whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //Get the food id and it's details
            $food_id=$_GET['food_id'];
            //to get details of selected food create sql query
            $sql="SELECT * FROM tbl_food WHERE id=$food_id";
            //execute the query
            $result=mysqli_query($conn, $sql);
            //count the rows
            $count = mysqli_num_rows($result);
            //check whether the data is available or not
            if($count ==1)//we use one cause data is unique has to just be that one available
            {
                //Food data is available
                //get details of the data from database
                $row=mysqli_fetch_assoc($result);
                $title=$row['title'];
                $price=$row['price'];
                $image_name=$row['image_name'];
            }
            else
            {
                //food data is not available, redirect to homepage
                header('location:'.SITEURL);
            }
        }
        else
        {
            //id not set redirect to homepage
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>


                    <div class="food-menu-img">
                        <?php
                            //check whether image is present or not
                            if($image_name=="")
                            {
                                //image is not available
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
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">
                        <p class="food-price">&#8358;<?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php
                //check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //get all details from the form
                    $food=$_POST['food'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty'];
                    $total=$price * $qty;
                    $order_date=date("Y-m-d h:i:sa");//year, month, day, hour:minutes:seconds:am or pm
                    $status="Ordered";// ordered, on delivery, delivered cancelled
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email=$_POST['email'];
                    $customer_address=$_POST['address'];

                    //save data to database
                    //create sql to save the data
                    $sql2="INSERT INTO tbl_order SET
                    food='$food',
                    price=$price,
                    qty=$qty,
                    total=$total,
                    order_date='$order_date',
                    status='$status',
                    customer_name='$customer_name',
                    customer_contact='$customer_contact',
                    customer_email='$customer_email',
                    customer_address='$customer_address'
                    ";

                    //execute the query
                    $result2=mysqli_query($conn, $sql2);
                    //check whether query executed successfully or not
                    if($result2==TRUE)
                    {
                        //query successful and data saved to database
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //query unsucessful and data not saved to database
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food</div>";
                        header('location:'.SITEURL);
                    }

                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
    <?php 
        include('partials-front/footer.php');
?>
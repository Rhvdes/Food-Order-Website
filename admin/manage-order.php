 <?php
include('partials/menu.php');
?> 
<link rel="stylesheet" href="../css/order.css">
<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br><br>
        
        <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
            
            <table>
                <tr>
                    <th>S.N.</th>
                    <th>Food</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                <?php
                    //get all details from database
                    //create sql query
                    $sql= "SELECT * FROM tbl_order ORDER BY id DESC";//THIS Would display the latest order
                    //execute query
                    $result=mysqli_query($conn, $sql);
                    //count rows
                    $count=mysqli_num_rows($result);
                    $sn=1;// create a serial number variable and set value to 1 to allow auto increment
                    //check if data is available
                    if($count>0)
                    {
                        //order available
                        //use while loop to display data from database
                        while($row=mysqli_fetch_assoc($result))
                        {
                            //get all individual data
                            $id=$row['id'];
                            $food=$row['food'];
                            $price=$row['price'];
                            $qty=$row['qty'];
                            $total=$row['total'];
                            $order_date=$row['order_date'];
                            $status=$row['status'];
                            $customer_name=$row['customer_name'];
                            $customer_contact=$row['customer_contact'];
                            $customer_email=$row['customer_email'];
                            $customer_address=$row['customer_address'];

                        ?>
                        <tr>
                            <td><?php echo $sn++;?></td>
                            <td><?php echo $food;?></td>
                            <td>&#8358;<?php echo $price;?></td>
                            <td><?php echo $qty;?></td>
                            <td>&#8358;<?php echo $total;?></td>
                            <td><?php echo $order_date;?></td>
                            <td>
                                <?php 
                                //Ordered, On Delivery, Delivered, Cancelled
                                    if($status=="Ordered")
                                    {
                                        echo "<label>$status</label>";
                                    }
                                    elseif($status=="On Delivery")
                                    {
                                        echo "<label style='color:orange;'>$status</label>";
                                    }
                                    elseif($status=="Delivered")
                                    {
                                        echo "<label style='color:green;'>$status</label>";
                                    }
                                    elseif($status=="Cancelled")
                                    {
                                        echo "<label style='color:red;'>$status</label>";
                                    }
                                ?>
                            </td>
                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $customer_contact;?></td>
                            <td><?php echo $customer_email;?></td>
                            <td><?php echo $customer_address;?></td>
                            <td><a href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Update Order</a>
                            </td>
                        </tr>
                            <?php
                        }
                    }
                    else
                    {
                        //order not available
                        echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                    }
                ?>
            </table>
    </div>
  </div>
<!-- Main content section ends -->
<?php
include('partials/footer.php');
?>
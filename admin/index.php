<?php
include('partials/menu.php');
?>
 
    <!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>DASHBOARD</h1>
            <br><br>
            <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <br><br>
            <div class="col-4 text-center">
                <?php
                    //create sql query
                    $sql="SELECT * FROM tbl_category";
                    //execute query
                    $result=mysqli_query($conn, $sql);
                    //count the rows
                    $count=mysqli_num_rows($result);
                ?>
                <h1><?php echo $count;?></h1>
                <br/>
                Categories
            </div>
            <div class="col-4 text-center">
            <?php
                    //create sql query
                    $sql2="SELECT * FROM tbl_food";
                    //execute query
                    $result2=mysqli_query($conn, $sql2);
                    //count the rows
                    $count2=mysqli_num_rows($result2);
                ?>
                <h1><?php echo $count2;?></h1>
                <br/>
                Foods
            </div>
            <div class="col-4 text-center">
            <?php
                    //create sql query
                    $sql3="SELECT * FROM tbl_order";
                    //execute query
                    $result3=mysqli_query($conn, $sql3);
                    //count the rows
                    $count3=mysqli_num_rows($result3);
                ?>
                <h1><?php echo $count3;?></h1>
                <br/>
                Total Order
            </div>
            <div class="col-4 text-center">
                <?php
                    //create sql query use aggregrate function in sql to find total
                    $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE STATUS='Delivered'";

                    //execute the query
                    $result4=mysqli_query($conn, $sql4);

                    //get the value
                    $row=mysqli_fetch_assoc($result4);

                    //get the total income generated
                    $total_income=$row['Total'];
                ?>
                <h1>&#8358;<?php echo $total_income;?></h1>
                <br/>
                Income Generated
            </div>
            <div class="clear-fix"></div>
        </div>
    </div>
    <!-- Main Content Section Ends -->
    <?php
    include('partials/footer.php');    
    ?>
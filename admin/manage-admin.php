<?php
include('partials/menu.php');
?>
<!-- Main Content Section Starts -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            <br>

            <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//display session message
                unset($_SESSION['add']);//removing session messsage
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];//display session message
                unset($_SESSION['delete']);//removing session message
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }
            if(isset($_SESSION['change-pwd']))
            {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }
            if(isset($_SESSION['pwd-not-match']))
            {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }
            ?>
            <br> <br> <br>
            <!-- button to add Admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            <br><br><br>
            <table>
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                <?php
                    //query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
                    //execute the query
                    $result = mysqli_query($conn, $sql);
                    //check whether the query is executed or not
                    if($result==TRUE)
                    {
                        //count rows to check whether we have data in database or not
                        $count = mysqli_num_rows($result);//function to get all rows in database
                        $sn = 1;//create a variable and assign the value

                        
                        //check the number of rows
                        if($count > 0)
                        {
                            //we have data in database
                            while($rows = mysqli_fetch_assoc($result))
                            {
                                //uing while loop to get all the data from database
                                //and while loop would execute as long as there's data in database

                                //get individual data
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];


                                //display the value in our table
                                ?>
                                    <tr>
                                        <td><?php echo $sn++;?>.</td>
                                        <td><?php echo $full_name;?></td>
                                        <td><?php echo $username;?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>

                                        </td>
                                    </tr>
                                <?php


                            }
                        }
                        else
                        {
                            //we do not have data in database
                        }
                    }
                
                
                ?>
            </table>
        </div>
    </div>
    <!-- Main Content Section Ends -->
    <?php
    include('partials/footer.php');    
    ?>
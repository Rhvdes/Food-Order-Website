
</body>
</html>

<?php
    include('../config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Register</h1>
        <br>
        <?php
            if(isset($_SESSION['failed-register']))
            {
                echo $_SESSION['failed-register'];
                unset($_SESSION['failed-register']);
            }
            if(isset($_SESSION['register']))
            {
                echo $_SESSION['register'];
                unset($_SESSION['register']);
            }
        ?>
        <br>

        <!-- Registration Form Starts -->
        <form action="" method="POST" class="text-center">
            Full Name: <br>
            <input type="text" name="full_name" placeholder="Enter Fullname" required> <br> <br>
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username" required> <br> <br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password" required> <br> <br>
            <input type="submit" name="submit" value="Register" class="btn-primary">
        </form>
        <br>
        <!-- Registration Form Ends -->
        <p class="text-center">Created By - <a href="#">Sulaiman Awwal</a></p>
    </div>
   <?php
    include('../config/constants.php');
    session_start();

    if (isset($_POST['submit'])) 
    {
        // Retrieve the username, password, and full name from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

        if (empty($username) || empty($password) || empty($full_name)) 
        {
            $_SESSION['failed-register'] = "<div class='error'>Please enter all fields</div>";
            header('location:'.SITEURL.'admin/register.php');
            // $url = SITEURL . 'admin/register.php';
            // echo "<script>window.location.href = '$url';</script>";
            exit();
        }

        // Check if the username already exists in the admin table
        $check_username_sql = "SELECT * FROM tbl_admin WHERE username = '$username'";
        $check_username_result = mysqli_query($conn, $check_username_sql);

        if (mysqli_num_rows($check_username_result) > 0) 
        {
            // Username already exists, display an error message
            $_SESSION['register'] = "<div class='error'>Username already taken. Please choose a different username.</div>";
            header('location:'.SITEURL.'admin/register.php');
            // $url = SITEURL . 'admin/register.php';
            // echo "<script>window.location.href = '$url';</script>";
            exit();
        }
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the username, hashed password, and full name into the admin table
        $register_sql = "INSERT INTO tbl_admin (username, password, full_name) VALUES ('$username', '$hashedPassword', '$full_name')";
        $register_result = mysqli_query($conn, $register_sql);

        if ($register_result) 
        {
            // Registration successful, display success message
            $_SESSION['registered'] = "<div class='success'>Registration successful. You can now log in.</div>";
            header('location:'.SITEURL.'admin/login.php');
            // $url = SITEURL . 'admin/login.php';
            // echo "<script>window.location.href = '$url';</script>";
            exit();
        } 
        else 
        {
            // Registration failed, display error message
            $_SESSION['register'] = "<div class='error'>Registration failed. Please try again.</div>";
            header('location:'.SITEURL.'admin/register.php');
            // $url = SITEURL . 'admin/register.php';
            // echo "<script>window.location.href = '$url';</script>";
            exit();
        }
    }
?>
<!-- Rest of the register page HTML -->
</body>
</html>


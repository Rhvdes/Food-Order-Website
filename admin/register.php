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
    // Process the registration form submission
    //check if submit button is clicked or not
    if (isset($_POST['submit'])) 
    {
        // Retrieve the username and password from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if the username already exists in the admin table
        $check_username_sql = "SELECT * FROM tbl_admin WHERE username = '$username'";
        $check_username_result = mysqli_query($conn, $check_username_sql);

        if (mysqli_num_rows($check_username_result) > 0) 
        {
            // Username already exists, display an error message
            $_SESSION['register'] = "<div class='error'>Username already taken. Please choose a different username.</div>";
            header('location:'.SITEURL.'admin/register.php');
            exit();
        }

          // Validate the username using a regular expression
          if (!preg_match('/^[a-zA-Z]+$/', $username)) 
          {
            // Username should only contain letters, display an error message
            $_SESSION['failed-register'] = "<div class='error'>Invalid username. Please use only letters.</div>";
            header('location: register.php');
            exit();
        }
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the username and hashed password into the admin table
        $register_sql = "INSERT INTO tbl_admin (username, password) VALUES ('$username', '$hashedPassword')";
        $register_result = mysqli_query($conn, $register_sql);

        if ($register_result==true) 
        {
            // Registration successful, display success message
            $_SESSION['registered'] = "<div class='success'>Registration successful. You can now log in.</div>";
            header('location:'.SITEURL.'admin/login.php');
            exit();
        } else {
            // Registration failed, display error message
            $_SESSION['register'] = "<div class='error'>Registration failed. Please try again.</div>";
            header('location:'.SITEURL.'admin/register.php');
            exit();
        }
    }
?>

</body>
</html>


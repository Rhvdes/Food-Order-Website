<?php
    include('../config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>
        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset ($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }

        ?>
        <br>

        <!-- Login Form Starts -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"> <br> <br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"> <br> <br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
        </form>
        <br>
        <!-- Login Form Ends -->
        <p class="text-center">Created By - <a href="#">Sulaiman Awwal</a></p>
    </div>
</body>
</html>
<?php
    //check whether submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for login
        //1. Get the Data from login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. sql query to check whether the username and password exists
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

        //3. execute sql query
        $result = mysqli_query($conn, $sql);

        //4. count rows to check whether user exists or  not
        $count = mysqli_num_rows($result);
        if($count == 1)
        {
            //user available, login success
            //Create a session message
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            //create a session to check if user is logged in or not
            $_SESSION['user'] = $username;
            //redirect to home page
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available, login failed
             //Create a session message and redirect to login page
             $_SESSION['login'] = "<div class='error'>Username or Password Incorrect</div>";
             header('location:'.SITEURL.'admin/login.php');
        }
    }
?>
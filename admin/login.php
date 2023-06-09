<?php
    include('../config/constants.php');

    // Check if the user is already logged in and redirect to the dashboard
    if (isset($_SESSION['user'])) {
        $url = SITEURL . 'admin/';
        echo "<script>window.location.href = '$url';</script>";
        exit();
    }
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
            if (isset($_SESSION['login'])) 
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if (isset($_SESSION['registered'])) 
            {
                echo $_SESSION['registered'];
                unset($_SESSION['registered']);
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

        <p class="text-center">Don't have an account? <a href="<?php echo SITEURL ?>admin/register.php">Click here</a></p>
        <br>
        <p class="text-center">Created By - <a href="#">Sulaiman Awwal</a></p>
    </div>
</body>
</html>

<?php
    include('../config/constants.php');
    session_start();

    // Check if the user is already logged in and redirect to the dashboard
    if (isset($_SESSION['user'])) 
    {
        header('location:'.SITEURL.'admin/');
        // $url = SITEURL . 'admin/';
        // echo "<script>window.location.href = '$url';</script>";
        exit();
    }

    if (isset($_POST['submit'])) {
        // Retrieve the username and password from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($username) || empty($password)) {
            $_SESSION['login'] = "<div class='error'>Please enter both username and password</div>";
            $url = SITEURL . 'admin/login.php';
            echo "<script>window.location.href = '$url';</script>";
            exit();
        }

        // Retrieve the hashed password from the database based on the entered username
        $sql = "SELECT password FROM tbl_admin WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                // Verify the entered password with the hashed password
                if (password_verify($password, $hashedPassword)) {
                    // Password is correct, login success
                    $_SESSION['login'] = "<div class='success'>Login Successful</div>";
                    $_SESSION['user'] = $username;
                    header('location:'.SITEURL.'admin/');
                    // $url = SITEURL . 'admin/';
                    // echo "<script>window.location.href = '$url';</script>";
                    exit();
                } else {
                    // Incorrect password
                    $_SESSION['login'] = "<div class='error'>Incorrect username or password</div>";
                    header('location:'.SITEURL.'admin/login.php');
                    // $url = SITEURL . 'admin/login.php';
                    // echo "<script>window.location.href = '$url';</script>";
                    exit();
                }
            } else {
                // Username not found
                $_SESSION['login'] = "<div class='error'>Incorrect username or password</div>";
                header('location:'.SITEURL.'admin/login.php');
                // $url = SITEURL . 'admin/login.php';
                // echo "<script>window.location.href = '$url';</script>";
                exit();
            }
        } else {
            // Database query failed
            $_SESSION['login'] = "<div class='error'>Database error. Please try again</div>";
            header('location:'.SITEURL.'admin/login.php');
            // $url = SITEURL . 'admin/login.php';
            // echo "<script>window.location.href = '$url';</script>";
            exit();
        }
    }
?>

<!-- Rest of the login page HTML -->

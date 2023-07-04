<link rel="stylesheet" href="../Food-Order/css/order.css">
<?php
    include('partials-front/menu.php');
?>
<!-- Main content section starts -->
<div class="main-content">
    <div class="wrapper">
    <h1>Contact Us</h1>
    <form action="" method="POST">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      
      <label for="message">Message:</label>
      <textarea id="message" name="message" rows="4" required></textarea>
      
      <input type="submit" value="Submit" name="submit">
    </form>
    <?php
        //check whether submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //buttton clicked
            //get all details from form
            $name=$_POST['name'];
            $email=$_POST['email'];
            $message=$_POST['message'];

            //create sql query
            $sql="INSERT INTO tbl_contact SET
            name='$name',
            email='$email',
            message='$message'
            ";
            //execute the query
            $result=mysqli_query($conn, $sql);
            //check whether data successfully saved to database or not
            if($result==true)
            {
                //data successsfully saved
                // Display a session message
                $_SESSION['contact'] = "<div class='success'>Form Submited Successfully</div>";
                //redirect to homepage
                header('location:'.SITEURL);
            }
            else
            {
                //data not saved successfully
                //Display Error Prompt
                $_SESSION['contact'] = "<div class='error'>Unable to Submit Form</div>";
                //redirect to homepage
                header('location:'.SITEURL);
            }
        }
        else
        {
            //button not clicked
        }
    
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    // {
    //   // Retrieve form data
    //   $name = $_POST['name'];
    //   $email = $_POST['email'];
    //   $message = $_POST['message'];
    
    //   // Insert the data into the database
    //   $sql = "INSERT INTO tbl_contact (name, email, message) VALUES ('$name', '$email', '$message')";
    
    //   if (mysqli_query($conn, $sql)) 
    //   {
    //     // Display a session message
    //     $_SESSION['contact'] = "<div class='success'>Form Submited Successfully</div>";
    //      // Redirect back to the contact page
    //     header('location:'.SITEURL);
    //   } 
    //   else 
    //   {
    //     // Display an error prompt
    //     $_SESSION['contact'] = "<div class='error'>Unable to Submit Form</div>";
    //      // Redirect back to the contact page
    //      header('location:'.SITEURL);
    //   }
    // }
    // exit;
    
    ?>
  </div>
</body>
</html>
    </div>
</div>
<!-- Main content section ends -->
<?php
    include('partials-front/footer.php');
?>
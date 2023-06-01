<?php
//start session

    session_start();
   
        
       

      
      
    
  

  //create constants to store from repeating values
    define('SITEURL', 'http://localhost/WEB/Food-Order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

  //execute query and save data into database
  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));//database connection
  $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));//selecting database
//   $result = mysqli_query($conn, $sql);
//       if ($result === false) 
//       {
//           die(mysqli_error($conn)); // handle the error
//       } 
//       else 
//       {
//           // success
//       }



?>
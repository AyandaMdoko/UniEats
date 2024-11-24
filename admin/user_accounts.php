<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
   exit;
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   
   // Delete user from `users` table
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->bind_param('i', $delete_id);
   $delete_users->execute();
   
   // Delete orders associated with the user
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE User_id = ?");
   $delete_order->bind_param('i', $delete_id);
   $delete_order->execute();
   
   // Delete cart associated with the user
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE User_id = ?");
   $delete_cart->bind_param('i', $delete_id);
   $delete_cart->execute();

   header('location:user_accounts.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link rel="icon" href="../images/fast-food.png">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include '../elements/admin_header.php' ?>

<!-- user accounts section starts  -->

<section class="accounts">

   <h1 class="heading">users account</h1>

   <div class="box-container">

   <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      $result = $select_account->get_result();
      
      if($result->num_rows > 0){
         while($fetch_accounts = $result->fetch_assoc()){  
   ?>
   <div class="box">
      <p> username : <span><?= $fetch_accounts['Name']; ?></span> </p>
     
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available</p>';
      }
   ?>

   </div>

</section>

<!-- user accounts section ends -->

<!-- custom js file link  -->
<script src="admin.js"></script>

</body>
</html>


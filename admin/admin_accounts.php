<?php

include '../elements/dbconnect.php';

session_start();

$admin_id = $_SESSION['Admin_id'];

// Check if admin is logged in
if(!isset($admin_id)){
   header('location:admin_login.php');
   exit;
}

// Fetch admin role from the database
$sql = "SELECT Position FROM `administrators` WHERE Admin_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $admin_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin_data = mysqli_fetch_assoc($result);

// Set admin role in session
$admin_role = $admin_data['Position'];

if(isset($_GET['delete']) && $admin_role === 'Manager'){
   $delete_id = $_GET['delete'];
   $sql = "DELETE FROM `administrators` WHERE Admin_id = ?";
   $stmt = mysqli_prepare($conn, $sql);
   mysqli_stmt_bind_param($stmt, 'i', $delete_id);
   mysqli_stmt_execute($stmt);
   header('location:admin_accounts.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="icon" href="../images/fast-food.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admins Accounts</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php include '../elements/admin_header.php' ?>

<section class="accounts">
   <h1 class="heading">Admins Account</h1>
   <div class="box-container">

   <?php if ($admin_role === 'Manager') : ?>
   <!-- Only Manager can see this section -->
   <div class="box">
      <p>Register new admin</p>
      <a href="register_admin.php" class="option-btn">Register</a>
   </div>
   <?php endif; ?>

   <?php
      $sql = "SELECT * FROM `administrators`";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) > 0){
         while($fetch_accounts = mysqli_fetch_assoc($result)){  
   ?>
   <div class="box">
      <p> Staff Name : <span><?= $fetch_accounts['Name']; ?></span> </p>
      <p> Staff Number : <span><?= $fetch_accounts['Admin_Num']; ?></span> </p>
      <p> Role : <span><?= $fetch_accounts['Position']; ?></span> </p>
      <div class="flex-btn">
         <?php if ($admin_role === 'Manager' && $fetch_accounts['Admin_id'] != $admin_id) : ?>
            <!-- Only Manager can delete accounts, except their own -->
            <a href="admin_accounts.php?delete=<?= $fetch_accounts['Admin_id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
         <?php endif; ?>
         <?php
            if($fetch_accounts['Admin_Num'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">Update</a>';
            }
         ?>
      </div>
   </div>
   <?php
      }
   } else {
      echo '<p class="empty">No accounts available</p>';
   }
   ?>

   </div>
</section>

<script src="admin.js"></script>
</body>
</html>
